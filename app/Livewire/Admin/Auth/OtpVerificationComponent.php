<?php

namespace App\Livewire\Admin\Auth;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Traits\LoginSessionTraits;
use Illuminate\Support\Facades\Auth;

class OtpVerificationComponent extends Component
{
    use LoginSessionTraits;
    public $otp= [];
    public function render()
    {
        return view('livewire.admin.auth.otp-verification-component');
    }

    public function otpVerify(){
        $checkOtp= User::where('otp',implode("",$this->otp))->first();
        // dd($checkOtp);
        if(!$checkOtp):
            $this->otp=[];
            session()->flash('error',"Given otp has been invalid,Please try again");
            return false;
        endif;
        if(now()->diffInMinutes($checkOtp->expire_at) <=0):
            $this->otp=[];
            session()->flash('error',"Given otp has been expired,Please try again");
            return false;
        endif;
        $user = User::find($checkOtp->id);
        if($user):
            $checkOtp->update([
                'expire_at'=>now(),
                'verified_at'=>now(),
            ]);
            Auth::login($user);
            sleep(1);
            $loginSessionData = [
                'id'=>auth()->user()->id,
                'latitude'=>session()->get('lat'),
                'logitude'=>session()->get('long'),
                'ip_address'=>request()->ip(),
                'login_time'=>Carbon::now()->format('Y-m-d H:i:s'),
                'is_logged_in'=>'0',
            ];
            $this->loginSessionStore($loginSessionData);
            sleep(1);
            return to_route('admin.dashboard');
        endif;
    }
}
