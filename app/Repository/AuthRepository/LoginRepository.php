<?php

namespace App\Repository\AuthRepository;

use App\Models\User;

class LoginRepository {

    
    public function login (array $userDetails) {

       
    }


    private function checkUserLastActiviity($userName) {
        
    }

    private function sendOtp ($email) {
        $user = User::where('email',$email)->first();
        if((now()->diffInHours($user->verified_at) >=24 && getSettingValue('otp verification')=='yes') || ($user->verified_at ==null && getSettingValue('otp verification')=='yes')):
            if(now()->diffInMinutes($user->expire_at) >=120 || $user->verified_at ==null):
                $otp = rand(1234, 9999);
            else:
                $otp = $user->otp;
            endif;
            sendOtp($user->mobile_no,$otp);
            $user->update([
                'otp'=>$otp,
                'expire_at'=>now()->addMinutes(120)
            ]);
        endif;
    }

    private function verifyOtp ($otp) {

    }

    private function checkHowManyLoginDevice() {

    }
}
