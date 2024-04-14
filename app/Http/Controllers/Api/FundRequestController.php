<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FundRequestRequest;
use App\Models\ApiToken;
use App\Traits\PayoutTraits;
use App\Traits\EkoPayoutTrait;
use Illuminate\Support\Facades\Validator;

class FundRequestController extends Controller
{
    use PayoutTraits,EkoPayoutTrait;
    public function payout(FundRequestRequest $request) {
        $checkToken  = ApiToken::where(['ip_address'=>$request->input('ip_address'),'token'=>$request->input('token')])->first();
        if(!$checkToken)
        return response()->json([
            'status'=>false,
            'msg'=>"Invalid Api token or ip address your current ip is ".$request->ip_address
        ]);
       $request['user_id'] = $checkToken->user_id;
       $request['payment_mode'] = getPaymentModesId($request->input('payment_mode'));
    //    $response = $this->payoutApiRequest($request);
       $response = $this->ekoPayoutApi($request);;
       return $response;
    }
}
