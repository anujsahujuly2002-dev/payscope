<?php

namespace App\Http\Controllers\Mobile\Auth;

use Illuminate\Http\Request;
use App\Traits\LoginSessionTraits;
use App\Http\Controllers\Controller;
use App\Repository\AuthRepository\LoginRepository;
use App\Http\Requests\MobileRequest\Auth\LoginRequest;
use App\Http\Requests\MobileRequest\Auth\OtpVerifyRequest;
use App\Http\Requests\MobileRequest\Auth\ResendOtpRequest;

class LoginController extends Controller
{

    use LoginSessionTraits;
    private $loginRepo;
    public function __construct(LoginRepository $loginRepository) {
        $this->loginRepo = $loginRepository;
    }
    public function login(LoginRequest $request) {
        $userDetails = [
            'username'=> $request->input('username'),
            'password'=>$request->input('password'),
            'type'=>"mobile_api",
        ];
        $user = $this->loginRepo->login($userDetails);
        return response()->json($user);
    }


    public function otpVerify(OtpVerifyRequest $request) {
        $otpVerify = $this->loginRepo->otpVerify($request->input('otp'),'mobile_api');
        return  response()->json($otpVerify);
    }

    public function resendOtp(ResendOtpRequest $request) {
        $resendOtp = $this->loginRepo->resendOtp($request->input('email'),'mobile_api');
        return  response()->json($resendOtp);
    }
}
