<?php

namespace App\Http\Controllers\Mobile\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobileRequest\Auth\LoginRequest;
use App\Repository\AuthRepository\LoginRepository;
use App\Traits\LoginSessionTraits;
use Illuminate\Http\Request;

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
        if($user):
            return response()->json($user);
        else:
            return response()->json([
                'status'=>false,
                "message"=>"Request can not be complete",
            ],500);
        endif;
    }
}
