<?php

namespace App\Livewire\Admin\Payout;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Status;
use App\Models\Wallet;
use Livewire\Component;
use App\Models\FundRequest;
use App\Models\PaymentMode;
use Livewire\WithPagination;
use App\Models\PayoutRequestHistory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PayoutRequest extends Component
{
    use WithPagination;
    public $paymentModes;
    public $payoutFormRequest = [];
    public $statuses = [];
    // public $payoutRequestData;
    public $start_date;
    public $end_date;
    public $value;
    public $agentId;
    public $status;

    public function mount() {
        $this->payoutRequestData = FundRequest::when(auth()->user()->getRoleNames()->first()=='api-partner',function($query){
            $query->where('user_id',auth()->user()->id);
        })->latest()->paginate(10);
    }

    public function render()
    {
        if(!auth()->user()->can('payout-request')):
            throw UnauthorizedException::forPermissions(['payout-request']);
        endif;
        $this->paymentModes = PaymentMode::whereIn('id',['1','2'])->get();
        $this->statuses =  Status::get();
        $payoutRequestData = FundRequest::when(auth()->user()->getRoleNames()->first()=='api-partner',function($query){
            $query->where('user_id',auth()->user()->id);
        })->orderBy('id','desc')->latest()->paginate(10);
        return view('livewire.admin.payout.payout-request',compact('payoutRequestData'));
    }

    public function payoutRequest() {
        
        if(!auth()->user()->can('payout-new-request')):
            throw UnauthorizedException::forPermissions(['payout-new-request']);
        endif;
        $this->reset();
        $this->dispatch('show-form');
    }

    public function storePayoutNewRequest() {
        $validateData = Validator::make($this->payoutFormRequest,[
            'account_number'=>'required|numeric|min:5',
            'ifsc_code' =>'required',
            'account_holder_name'=>'required|string|min:3',
            'amount'=>'required|numeric|min:10',
            'payment_mode'=>'required'
        ])->validate();
       //check pending fund request
        $checkPendingRequest  = FundRequest::where(['user_id'=>auth()->user()->id,'status_id'=>'1'])->count();
        if($checkPendingRequest >0):
            $this->dispatch('hide-form');
            return redirect()->back()->with('error','One request is already submitted');
        endif;
        if(auth()->user()->walletAmount->amount < ($validateData['amount']+getCommission("dmt",$validateData['amount']))):
            $this->dispatch('hide-form');
            return redirect()->back()->with('error','Low balance to make this request.');
        endif;
        $previousTransactionTimeCheck = FundRequest::where(['user_id'=>auth()->user()->id,'account_number'=>$validateData['account_number'],'amount'=>$validateData['amount']])->whereBetween('created_at',[Carbon::now()->subSeconds(30)->format('Y-m-d H:i:s'), Carbon::now()->addSeconds(30)->format('Y-m-d H:i:s')])->count();
        if($previousTransactionTimeCheck > 0):
            $this->dispatch('hide-form');
            return redirect()->back()->with('error','Next transaction allowed after 1 Min.');
        endif;
        do {
            $validateData['payoutid'] = 'GROSC'.rand(111111111111, 999999999999);
        } while (FundRequest::where("payout_id", $validateData['payoutid'])->first() instanceof FundRequest);
        
        try {
            $openingBalance = auth()->user()->walletAmount->amount;
            $fundRequest=FundRequest::create([
                'user_id'=>auth()->user()->id,
                'account_number'=>$validateData['account_number'],
                'account_holder_name'=>$validateData['account_holder_name'],
                'ifsc_code'=>$validateData['ifsc_code'],
                'amount'=>$validateData['amount'],
                'payment_mode_id'=>$validateData['payment_mode'],
                'status_id'=>'1',
                'type'=>'Bank',
                'pay_type'=>'payout',
                'payout_id'=>$validateData['payoutid'],
                'payout_ref'=>$validateData['payoutid']
            ]);
        } catch (\Exception $e) {
            $this->dispatch('hide-form');
            return redirect()->back()->with('error','Duplicate Transaction Not Allowed, Please Check Transaction History');
        }

        Wallet::where('user_id',auth()->user()->id)->update([
            'amount'=>auth()->user()->walletAmount->amount-($validateData['amount']+getCommission("dmt",$validateData['amount'])),
        ]);
        $adminId = User::whereHas('roles',function($q){
            $q->where('name','super-admin');
        })->first();
        $payoutRequestHistories = PayoutRequestHistory::create([
            'user_id'=>auth()->user()->id,
            'fund_request_id'=>$fundRequest->id,
            'api_id'=>'1',
            'amount'=>$validateData['amount'],
            'charge'=>getCommission("dmt",$validateData['amount']),
            'status_id'=>'1',
            'credited_by'=>$adminId->id,
            'balance'=>auth()->user()->walletAmount->amount,
            'closing_balnce'=>$openingBalance - ($validateData['amount']+getCommission("dmt",$validateData['amount'])),
            'type'=>"debit",
            'transtype'=>"fund",
            'product'=>'payout',
            'remarks'=>'Bank Settlement'
        ]);

        $url = "https://api.instantpay.in/payments/payout";
        $new_arr[]= unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.request()->ip()));
        $requestParameter = [
            "payer" => [
                "bankProfileId" => "24255428726",
                "accountNumber" => "123263400000200"
            ],
            "payee"   => [
                "name"           => $validateData['account_holder_name'],
                "accountNumber"  => $validateData['account_number'],
                "bankIfsc"       => $validateData['ifsc_code']
            ], 

            "transferMode"       => $validateData['payment_mode']=='1'?"IMPS":"NEFT",
            "transferAmount"     => $validateData['amount']+getCommission("dmt",$validateData['amount']),
            "externalRef"        =>$validateData['payoutid'],
            "latitude"           => $new_arr[0]['geoplugin_latitude'],
            "longitude"          => $new_arr[0]['geoplugin_longitude'],
            "remarks"            => 'test',
            "purpose"           => "REIMBURSEMENT",
            "otp"                => "",
            "otpReference"       => ""
        ];

        $headers = [
            'X-Ipay-Auth-Code'=>'1',
            'X-Ipay-Client-Id'=>'YWY3OTAzYzNlM2ExZTJlOUWx2c0hIFCZJmVsLIO8Mxw=',
            'X-Ipay-Client-Secret'=>'6252d9bfe8832ff8cd648ed2f4e9cd5820c8e5864bb5ac15217670c74bafd73b',
            'X-Ipay-Endpoint-Ip'=>request()->ip(),
            'Content-Type'=>'application/json'
        ];

        $res = apiCall($headers,$url,$requestParameter,true,$validateData['payoutid']);
        if(isset($res['statuscode']) && in_array($res['statuscode'],['TXN','TUP'])):
            FundRequest::where('id',$fundRequest->id)->update([
                'status_id'=>'2',
                'payout_ref' =>$res['data']['txnReferenceId'],
            ]);
            PayoutRequestHistory::where('id',$fundRequest->id)->update([
                'status_id'=>'2',
            ]);
            $this->dispatch('hide-form');
            return redirect()->back()->with('success','Your '.$res['status']);
        else:
            FundRequest::where('id',$fundRequest->id)->update([
                'status_id'=>'3',
            ]);
            PayoutRequestHistory::where('id',$fundRequest->id)->update([
                'status_id'=>'3',
                'closing_balnce'=>$openingBalance
            ]);
            Wallet::where('user_id',auth()->user()->id)->update([
                'amount'=>auth()->user()->walletAmount->amount+getCommission("dmt",$validateData['amount']),
            ]);
            $this->dispatch('hide-form');
            return redirect()->back()->with('error','Your '.$res['status']);
        endif;
    }

    public function search() {
        $this->payoutRequestData = FundRequest::when(auth()->user()->getRoleNames()->first()=='api-partner',function($query){
            $query->where('user_id',auth()->user()->id);
        })
        ->when($this->start_date !=null && $this->end_date ==null,function($u){
            $u->whereDate('created_at',$this->start_date);
        })
        ->when($this->start_date !=null && $this->end_date !=null,function($twoBetweenDates){
            $twoBetweenDates->whereDate('created_at','>=',$this->start_date)->whereDate("created_at","<=",$this->end_date);
        })
        ->when($this->status !=null,function($u){
            $u->where('status_id',$this->status);
        })
        ->when($this->agentId !=null,function($u){
            $u->where('user_id',$this->agentId);
        })
        ->when($this->value !=null,function($u){
            $u->where('payout_ref',$this->value);
        })
        ->get();
    }


}
