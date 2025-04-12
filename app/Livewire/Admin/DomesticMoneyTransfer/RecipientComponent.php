<?php

namespace App\Livewire\Admin\DomesticMoneyTransfer;

use App\Models\Payer;
use App\Traits\DomesticMoneyTransferTrait;
use Livewire\Component;

class RecipientComponent extends Component
{
    public $otpVerificationForm =true;
    public $otpReferenceID;
    public $otp_code;
    use DomesticMoneyTransferTrait;

    protected $rules = [
        'otp_code' => 'required|integer',
    ];
    public function render()
    {
        return view('livewire.admin.domestic-money-transfer.recipient-component');
    }

    public function payerRegistration() {
        if(!auth()->user()->can('remitter-registration') && checkRecordHasPermission(['remitter-registration']))
        throw UnauthorizedException::forPermissions(['remitter-registration']);
        $data['role'] = auth()->user()->getRoleNames()->first();
        $response  = $this->payerRegistrations($data);
        if(isset($response['statuscode']) && $response['statuscode'] =='OTP'){
            $this->otpReferenceID = $response['data']['referenceKey'];
            $this->otpVerificationForm = true;
            $this->dispatch('show-form');
        }else{
            sleep(1);
            session()->flash('error',$response['message']);
            return back();

        }

    }

    public function otpValidate() {
        $this->validate();
        $data = [
            'mobileNumber'=>auth()->user()->mobile_no,
            'otpReference'=>$this->otpReferenceID,
            'otp'=>$this->otp_code,
        ];
        $response = $this->otpVerification($data);
        dd($response);
        if($response['status']):
            User::find($this->ekyApiPartnerId)->update([
                'outlet_id'=>$response['data']['outletId'],
            ]);
            $this->reset();
            $this->dispatch('hide-form');
            return redirect()->back()->with('success',$response['msg']);
        else:
            $this->dispatch('hide-form');
            return redirect()->back()->with('error',$response['msg']);
        endif;
    }
}
