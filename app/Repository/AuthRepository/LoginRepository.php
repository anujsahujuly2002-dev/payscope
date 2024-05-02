<?php

namespace App\Repository\AuthRepository;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginRepository {

    private $message;
    
    public function login (array $userDetails) {
        /* if($this->checkOtpVerifyTime($userDetails['username'])):
            if($this->sendOtp($userDetails['username']))
            return $message = [
                "status"=>true,
                "message"=>"Otp send successfully",
            ];
        endif;
        if(!auth()->attempt(['email'=>$userDetails['username'],'password'=>$userDetails['password']])):
            $message =[ 
                'status'=>false,
                "message"=>"Invalid credentials,Please try again"
            ];
        else:

        endif; */
        if(!auth()->attempt(['email'=>$userDetails['username'],'password'=>$userDetails['password']])):
            $message =[ 
                'status'=>false,
                "message"=>"Invalid credentials,Please try again"
            ];
        else:
            if(!$this->checkOtpVerifyTime($userDetails['username'])):
                $message= [
                    'status'=>true,
                    "message"=>"You're account has been loged in"
                ];
                if($userDetails['type']=='mobile_api'):
                    $user = auth()->user();
                    $message['token'] = $user->createToken($userDetails['username'])->plainTextToken;
                endif;
            else:
                $this->sendOtp($userDetails['username']);
                $message= [
                    'status'=>true,
                    'otp'=>true,
                    "message"=>"Otp send successfully",
                ];
            endif;
        endif;
        return $message;
       
    }


    private function checkUserLastActiviity($userName) {
        
    }

    private function sendOtp ($email) {
        $user = User::where('email',$email)->first();
        $checkOtp = Otp::where('user_id',$user->id)->first();
        if(!is_null($checkOtp)):
            if(now()->diffInMinutes($checkOtp->expire_at) >=120 || $checkOtp->verified_at ==null):
                $otp = $this->generateOtp();
            else:
                $otp = $checkOtp->otp;
            endif;
            $checkOtp->update([
                'otp'=>$otp,
                'expire_at'=>now()->addMinutes(120)
            ]);
        else:
            $otp = $this->generateOtp();
            $createOtp = Otp::create([
                'user_id'=>$user->id,
                'otp'=>$user->id,
                'expire_at'=>now()->addMinutes(120),
            ]); 
        endif;
        sendOtp($user->mobile_no,$otp);
        return true;
    }

    private function verifyOtp ($otp) {

    }

    private function checkHowManyLoginDevice() {

    }


    private function checkOtpVerifyTime($email) {
        $user = User::where('email',$email)->first();
        $otp = Otp::where('user_id',$user->id)->first();
        return (now()->diffInHours($otp?->verified_at) >=24 && getSettingValue('otp verification')=='yes') || ($otp?->verified_at ==null && getSettingValue('otp verification')=='yes')?true:false;   
    }

    private function generateOtp() {
        return rand(1234, 9999);
    }

    public function otpVerify($otp) {
        
    }
}
