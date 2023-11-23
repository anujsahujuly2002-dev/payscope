<?php

namespace App\Livewire\Admin\Fund;

use Livewire\Component;
use App\Models\Bank;
use App\Models\Fund;
use App\Models\PaymentMode;
use App\Models\Status;
use App\Models\Wallet;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ManualRequest extends Component
{
    use WithFileUploads;
    public $banks;
    public $paymentModes;
    public $fundNewRequests=[];
    public $paySlip;
    public $approvedForm = false;
    public $status;
    public $remark;
    public $fund;
    public $start_date;
    public $end_date;
    public $funds;
    public $value;
    public $agentId;
    public function mount() {
        $this->funds = Fund::when(auth()->user()->getRoleNames()->first()=='api-partner',function($query){
            $query->where('user_id',auth()->user()->id);
        })->get();
    }
    public function render()
    {
        $this->banks = Bank::where('status','1')->get();
        $this->paymentModes = PaymentMode::get();
        $statuses = Status::get();
        return view('livewire.admin.fund.manual-request',compact('statuses'));
    }

    public function fundNewRequest() {
        if(!auth()->user()->can('fund-new-request'))
        throw UnauthorizedException::forPermissions(['fund-new-request']);
        $this->dispatch('show-form');
    }

    public function storeFundNewRequest() {
        $validateData = Validator::make($this->fundNewRequests,[
            'bank'=>'required',
            'amount'=>'required|numeric|min:100',
            'payment_mode'=>'required',
            'pay_date'=>'required',
            'reference_number'=>'required|unique:funds,references_no'
        ])->validate();
        if($this->paySlip !=null):
            $image = time().'.'.$this->paySlip->getClientOriginalExtension();
            Storage::putFileAs('public/upload/pay_slip/', $this->paySlip,$image);
        endif;
        $validateData['remark'] = $this->fundNewRequests['remark']??"";
        $funds = Fund::create([
            'user_id'=>auth()->user()->id,
            'bank_id'=>$validateData['bank'],
            'payment_mode_id'=>$validateData['payment_mode'],
            'credited_by' => auth()->user()->apiPartner->added_by,
            'amount'=>$validateData['amount'],
            'type'=>'type',
            'pay_date'=>$validateData['pay_date'],
            'pay_slip' =>$image??null,
            'references_no'=>$validateData['reference_number'],
            'remark'=>$validateData['remark']??null,
            'status_id'=>1
        ]);
        if($funds):
            $this->dispatch('hide-form');
            sleep(1);
            session()->flash('success','Fund Request Added Successfully !');
            return back();
        else:
            session()->flash('error','Fund Request Not Added Please try again !');
        endif;
    }

    public function updateRequest(Fund $fund) {
        if(!auth()->user()->can('approved-fund-request'))
        throw UnauthorizedException::forPermissions(['approved-fund-request']);
        $this->fund = $fund;
        $this->status = $fund->status->id;
        $this->remark = $fund->remark;
        $this->approvedForm = true;
        $this->dispatch('show-form');
    }

    public function updateFundRequest(){
        if($this->status=='2'):
            $wallets = Wallet::where('user_id', $this->fund->user_id)->first()->amount;
            Wallet::where('user_id', $this->fund->user_id)->update([
                'amount' => $wallets+ $this->fund->amount
            ]);
        endif;
        $updateFundRequest = $this->fund->update([
            'status_id'=> $this->status,
            'remark'=>$this->remark
        ]);
        if($updateFundRequest):
            $this->dispatch('hide-form');
            sleep(1);
            session()->flash('success','Fund Request Update Successfully !');
            return back();
        else:
            session()->flash('error','Fund Request Not Update Please try again !');
        endif;
    }

    public function search() {
        $this->funds = Fund::when(auth()->user()->getRoleNames()->first()=='api-partner',function($query){
            $query->where('user_id',auth()->user()->id);
        })->when($this->start_date !=null && $this->end_date ==null,function($u){
            $u->whereDate('created_at',$this->start_date);
        })->when($this->status !=null,function($u){
            $u->where('status_id',$this->status);
        })
        ->when($this->agentId !=null,function($u){
            $u->where('user_id',$this->agentId);
        })
        ->when($this->value !=null,function($u){
            $u->where('references_no',$this->value);
        })
        ->get();
    }
}
