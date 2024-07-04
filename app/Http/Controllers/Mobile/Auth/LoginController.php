<?php

namespace App\Http\Controllers\Mobile\Auth;

<<<<<<< HEAD
use App\Http\Controllers\Controller;
use App\Http\Requests\MobileRequest\Auth\LoginRequest;
use App\Repository\AuthRepository\LoginRepository;
use App\Traits\LoginSessionTraits;
use Illuminate\Http\Request;
=======
use Illuminate\Http\Request;
use App\Traits\LoginSessionTraits;
use App\Http\Controllers\Controller;
use App\Repository\AuthRepository\LoginRepository;
use App\Http\Requests\MobileRequest\Auth\LoginRequest;
use App\Http\Requests\MobileRequest\Auth\OtpVerifyRequest;
use App\Http\Requests\MobileRequest\Auth\ResendOtpRequest;
>>>>>>> edbb7088ad7a904f2f91b646a4572c9f89e9528b

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
<<<<<<< HEAD
            'type'=>"Api",
        ];
        $user = $this->loginRepo->login($userDetails);

=======
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
>>>>>>> edbb7088ad7a904f2f91b646a4572c9f89e9528b
    }
}
