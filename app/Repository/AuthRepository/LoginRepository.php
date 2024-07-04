<?php

namespace App\Repository\AuthRepository;

<<<<<<< HEAD
class LoginRepository {

    // private $credentials;

   /*  public function __construct(array $credentials){
        $this->credentials = $credentials;
    } */
    public function login (array $userDetails) {
        dd($userDetails);
=======
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginRepository {

    
    public function login (array $userDetails) {
        $response =[];
        $user = User::where('email',$userDetails['username'])->first();
        if(!Hash::check($userDetails['password'],$user->password)):
            $response =[ 
                'status'=>false,
                "message"=>"Invalid credentials,Please try again"
            ];
            return $response;
        endif;
        if(!$this->checkOtpVerifyTime($userDetails['username'])):
           if(auth()->attempt(['email'=>$userDetails['username'],'password'=>$userDetails['password']]));
                if($userDetails['type']=='mobile_api'):
                    if($this->checkAuthenticateUserRole(auth()->user()->email)):
                        $user = auth()->user();
                        $response['role']=ucwords(str_replace('-',' ',$user->getRoleNames()->first()));
                        $response['otp_verifiaction']=false;
                        $response['token']  = $user->createToken($userDetails['username'])->accessToken;
                    else:
                        $response['status']=false;
                        $response['message']="Invalid credentials, Please try again";
                        return $response;
                    endif;
                $response['status']=true;
                $response['message']="Login Successfully";
            endif;
        else:
            if($this->sendsOtp($userDetails['username'])):
                if($this->checkAuthenticateUserRole($userDetails['username'])):
                    $user = User::where('email',$userDetails['username'])->first();
                    $response['status']=true;
                    $response['mobile_no']=str_repeat('*',6).substr($user->mobile_no,-4);
                    $response['message']="Otp send successfully, you're registerd mobile no";
                else:
                    $response['status']=false;
                    $response['message']="Invalid credentials, Please try again";
                endif;
            else:
                $response['status']=false;
                $response['message']="Otp not send, Please try again";
            endif;
        endif;
        return $response;
    }


    private function checkUserLastActiviity($userName) {
        
    }

    private function sendsOtp ($email) {
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
                'expire_at'=>now()->addMinutes(120),
                'verified_at'=>null,
            ]);
        else:
            $otp = $this->generateOtp();
            $createOtp = Otp::create([
                'user_id'=>$user->id,
                'otp'=>$otp,
                'expire_at'=>now()->addMinutes(120),
            ]); 
        endif;
        sendOtp($user->mobile_no,$otp);
        return true;
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

    public function otpVerify($otp,$type='') {
        $checkOtp = Otp::where('otp',$otp)->whereNull('verified_at')->with('user')->first();
        if(!is_null($checkOtp)):
            if(!$this->checkOtpExpired($checkOtp->expire_at)):
                $response['status']=false;
                $response['message']="You're otp has been expired";

            else:
                $checkOtp->update([
                    'verified_at'=>now(),
                    'expire_at'=>now()
                ]);
                if($type=='mobile_api'):
                    if($this->checkAuthenticateUserRole($checkOtp->user->email)):
                        $user = auth()->user();
                        $response['role']=ucwords(str_replace('-',' ',$checkOtp->user->getRoleNames()->first()));
                        $response['otp_verifiaction']=false;
                        $response['token']  = $checkOtp->user->createToken($checkOtp->user->email)->accessToken;
                    else:
                        $response['status']=false;
                        $response['message']="Invalid credentials, Please try again";
                        return $response;
                    endif;
                endif;
                $response['status']=true;
                $response['message']="Login Successfully";
            endif;
        else:
            $response ['status']= false;
            $response['message'] ="You're otp is invalid";
        endif;
        return $response;
    }

    public function checkAuthenticateUserRole($email) {
        $user = User::where('email',$email)->first();
        return $user->getRoleNames()->first()=='retailer'?true:false;
    }


    public function checkOtpExpired($otpExpiredTime) {
        return $otpExpiredTime <= now()->format('Y-m-d H:i:s')?false:true;
    }


    public function resendOtp ($email) {
       $this->sendsOtp($email);
        return $response =[
            'status'=>true,
            "message"=>'Otp send successfully',
        ];
        
>>>>>>> edbb7088ad7a904f2f91b646a4572c9f89e9528b
    }
}
