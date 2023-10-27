<?php

namespace App\Livewire\Admin\Fund;

use Livewire\Component;
use App\Models\Bank;
use App\Models\Fund;
use App\Models\PaymentMode;
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
    public function render()
    {
        $this->banks = Bank::where('status','1')->get();
        $this->paymentModes = PaymentMode::get();
        $funds = Fund::when(auth()->user()->getRoleNames()->first()=='api-partner',function($query){
            $query->where('user_id',auth()->user()->id);
        })->get();
        return view('livewire.admin.fund.manual-request',compact('funds'));
    }

    public function fundNewRequest() {
        if(!auth()->user()->can('fund-new-request'))
        throw UnauthorizedException::forPermissions(['fund-new-request']);
        $this->dispatch('show-form');
    }

    public function storeFundNewRequest() {
        // dd($this->fundNewRequests);
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
        $validateData['remark'] = $this->fundNewRequests['remark'];
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
}
