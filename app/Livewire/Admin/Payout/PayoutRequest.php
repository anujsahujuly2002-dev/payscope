<?php

namespace App\Livewire\Admin\Payout;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\User;
use App\Models\Status;
use App\Models\Wallet;
use Livewire\Component;
use App\Models\FundRequest;
use App\Models\PaymentMode;
use App\Traits\PayoutTraits;
use Livewire\WithPagination;
use App\Traits\EkoPayoutTrait;
use App\Exports\PayoutRequestExport;
use App\Models\PayoutRequestHistory;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Psy\CodeCleaner\AssignThisVariablePass;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PayoutRequest extends Component
{
    use WithPagination,PayoutTraits,EkoPayoutTrait;
    public $paymentModes;
    public $payoutFormRequest = [];
    public $statuses = [];
    public $start_date;
    public $end_date;
    public $value;
    public $agentId;
    public $status;
    public $banks;

    public function updated() {
        $this->resetPage();
    }

    public function render()
    {
        if(!auth()->user()->can('payout-request')):
            throw UnauthorizedException::forPermissions(['payout-request']);
        endif;
        $this->paymentModes = PaymentMode::whereIn('id',['1','2'])->get();
        $this->banks = Bank::get();
        $this->statuses =  Status::get();
        $payoutRequestData = FundRequest::when(auth()->user()->getRoleNames()->first()=='api-partner',function($query){
            $query->where('user_id',auth()->user()->id);
        })->when(auth()->user()->getRoleNames()->first()=='retailer',function($query){
            $query->where('user_id',auth()->user()->id);
        })->when($this->start_date !=null && $this->end_date ==null,function($u){
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
            $u->where('payout_ref', 'like', '%'.$this->value.'%')->orWhere('payout_id','like','%'.$this->value.'%');
        })
        ->orderBy('id','desc')->latest()->paginate(100);
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

        $validateData['user_id']= auth()->user()->id;
        // $response = $this->payoutApiRequest($validateData);
        $response = $this->ekoPayoutApi($validateData);;
        $this->dispatch('hide-form');
        if($response['status']=='0005'):
            return redirect()->back()->with('success',$response['msg']);
        else:
            return redirect()->back()->with('error',$response['msg']);
        endif;
    }


    public function export() {
        $data = [
            'user_id'=>auth()->user()->getRoleNames()->first() =='super-admin'?$this->agentId:auth()->user()->id,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'status'=>$this->status,
            'value'=>$this->value
        ];
        return Excel::download(new PayoutRequestExport($data), time().'.xlsx');
    }


}
