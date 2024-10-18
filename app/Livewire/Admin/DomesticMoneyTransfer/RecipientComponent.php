<?php

namespace App\Livewire\Admin\DomesticMoneyTransfer;

use App\Models\Payer;
use App\Traits\DomesticMoneyTransferTrait;
use Livewire\Component;

class RecipientComponent extends Component
{
    public $otpVerificationForm =true;
    public $otpReference;
    use DomesticMoneyTransferTrait;
    protected $rules = [
        'otp_code' => 'required|integer',
    ];
    public function render()
    {
        return view('livewire.admin.domestic-money-transfer.recipient-component');
    }

    public function payerRegistration() {
       /*  if(!auth()->user()->can('fund-new-request'))
        throw UnauthorizedException::forPermissions(['fund-new-request']); */
        $data['role'] = auth()->user()->getRoleNames()->first();
        $response  = $this->payerRegistrations($data);
        if(isset($response['statuscode']) && $response['statuscode'] =='OTP'){
            $this->otpReference = $response['data']['otpReference'];
            $this->otpVerificationForm = true;
            $this->dispatch('show-form');
        }else{
            // dd();
            if(isset($response['statuscode']) &&$response['statuscode'] !='OTP' && $response['status'] ):
                Payer::create([
                    'user_id'=>auth()->user()->id,
                    'limit_per_transaction'=>$response['data']['limitPerTransaction'],
                    'limit_total'=>$response['data']['limitTotal'],
                    'limit_consumed'=>$response['data']['limitConsumed'],
                    'limit_available'=>$response['data']['limitAvailable'],
                    'limit_increase_offer'=>$response['data']['limitIncreaseOffer']?1:0,
                    'allow_profile_update'=>$response['data']['allowProfileUpdate']?1:0,
                    'maximum_daily_limit'=>$response['data']['limitDetails']['maximumDailyLimit'],
                    'consumed_daily_limit'=>$response['data']['limitDetails']['consumedDailyLimit'],
                    'available_daily_limit'=>$response['data']['limitDetails']['availableDailyLimit'],
                    'maximum_monthly_limit'=>$response['data']['limitDetails']['maximumMonthlyLimit'],
                    'consumed_monthly_limit'=>$response['data']['limitDetails']['consumedMonthlyLimit'],
                    'available_monthly_limit'=>$response['data']['limitDetails']['availableMonthlyLimit'],
                ]);
                sleep(1);
                session()->flash('success',$response['msg']);
                return back();
            else:
                sleep(1);
                session()->flash('error',$response['msg']);
                return back();
            endif;
           
        }
        
    }

    public function otpValidate() {
        $this->validate();
        $data = [
            'otpReference'=>$this->otpReferenceID,
            'otp'=>$this->otp_code,
        ];
        $response = $this->otpVerification($data);
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
