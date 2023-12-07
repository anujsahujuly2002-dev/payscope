<?php

namespace App\Livewire\Admin\Payout;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use Livewire\Component;
use App\Models\FundRequest;
use App\Models\PaymentMode;
use App\Models\PayoutRequestHistory;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Http;

class PayoutRequest extends Component
{
    public $paymentModes;
    public $payoutFormRequest = [];
    public function render()
    {
        if(!auth()->user()->can('payout-request')):
            throw UnauthorizedException::forPermissions(['payout-request']);
        endif;
        $this->paymentModes = PaymentMode::whereIn('id',['1','2'])->get();
        return view('livewire.admin.payout.payout-request');
    }

    public function payoutRequest() {
        if(!auth()->user()->can('payout-new-request')):
            throw UnauthorizedException::forPermissions(['payout-new-request']);
        endif;
        $this->dispatch('show-form');
    }

    public function storePayoutNewRequest() {
        // dd(request()->ip());
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
        if(auth()->user()->walletAmount->amount < $validateData['amount']):
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
            dd($e->getMessage());
            $this->dispatch('hide-form');
            return redirect()->back()->with('error','Duplicate Transaction Not Allowed, Please Check Transaction History');
        }

        Wallet::where('user_id',auth()->user()->id)->update([
            'amount'=>auth()->user()->walletAmount->amount-$validateData['amount'],
        ]);
        $adminId = User::whereHas('roles',function($q){
            $q->where('name','super-admin');
        })->first();
        $payoutRequestHistories = PayoutRequestHistory::create([
            'user_id'=>auth()->user()->id,
            'fund_request_id'=>$fundRequest->id,
            'api_id'=>'1',
            'amount'=>$validateData['amount'],
            'charge'=>0.00,
            'status_id'=>'1',
            'credited_by'=>$adminId->id,
            'balance'=>auth()->user()->walletAmount->amount,
            'type'=>"debit",
            'transtype'=>"fund",
            'product'=>'payout',
            'remarks'=>'Bank Settlement'
        ]);

        $url = "https://api.instantpay.in/payments/payout";
        $new_arr[]= unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
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
            "transferAmount"     => $validateData['amount'],
            "externalRef"        =>$validateData['payoutid'],
            "latitude"           => $new_arr[0]['geoplugin_latitude'],
            "longitude"          => $new_arr[0]['geoplugin_longitude'],
            "remarks"            => 'test',
            'alertEmail'         => auth()->user()->email,
            "purpose"           => "REIMBURSEMENT",
            "otp"                => "",
            "otpReference"       => ""
        ];

        $headers = [
            'X-Ipay-Auth-Code'=>'1',
            'X-Ipay-Client-Id'=>'YWY3OTAzYzNlM2ExZTJlOUWx2c0hIFCZJmVsLIO8Mxw=',
            'X-Ipay-Client-Secret'=>'6252d9bfe8832ff8cd648ed2f4e9cd5820c8e5864bb5ac15217670c74bafd73b',
            'X-Ipay-Endpoint-Ip'=>'1.22.138.249',
            'Content-Type'=>'application/json'
        ];

        $response = Http::withHeaders($headers)->post($url,$requestParameter);
        dd($response->body());



    }


}
