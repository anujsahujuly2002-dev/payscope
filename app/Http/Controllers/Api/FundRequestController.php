<?php

namespace App\Http\Controllers\Api;

use App\Models\Wallet;
use App\Models\ApiToken;
use App\Jobs\BulkPayoutJob;
use App\Models\FundRequest;
use App\Traits\PayoutTraits;
use Illuminate\Http\Request;
use App\Traits\EkoPayoutTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\FundRequestRequest;

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


    public function bulkPayout(Request $request) {
        $checkToken  = ApiToken::where(['ip_address'=>$request->input('ip_address'),'token'=>$request->input('token')])->first();
        if(!$checkToken)
        return response()->json([
            'status'=>false,
            'msg'=>"Invalid Api token or ip address your current ip is ".$request->ip_address
        ],422);
        $request['user_id'] = $checkToken->user_id;
        $request['payment_mode'] = getPaymentModesId($request->input('payment_mode'));
        $orderAmount  = 0;
        $commissionAmount = 0;
        $userDetails = [];
        do {
            $request['payoutid'] = 'GROBU'.rand(111111111111, 999999999999);
        } while (FundRequest::where("payout_id", $request['payoutid'])->first() instanceof FundRequest);
        foreach($request->input('userInformation') as $userInformation):
            $orderAmount +=$userInformation['amount'];
            $commissionAmount +=getCommission("dmt",$userInformation['amount'],$request['user_id']);
            $userDetails[]=[
                'account_number'=>$userInformation['account_number'],
                'account_holder_name'=>$userInformation['account_holder_name'],
                'ifsc_code'=>$userInformation['ifsc_code'],
                'amount'=>$userInformation['amount'],
                'user_id'=>$request['user_id'],
                'payment_mode'=>$request['payment_mode'],
                'payoutid'=>$request['payoutid'],
            ];
        endforeach;
        $walletAmount = Wallet::where('user_id',$request['user_id'])->first();
        if($orderAmount+$commissionAmount > ($walletAmount->amount-$walletAmount->locked_amuont)):
            return response()->json([
                'status'=>false,
                'msg'=>"Low balance to make this request."
            ],422);
        endif;
        // dd($userDetails);
        dispatch(new BulkPayoutJob($userDetails));
        
        return response()->json([
            'status'=>true,
            'transaction_id'=> $request['payoutid'],
            'msg'=>"Transaction Complete successfully"
        ],200);
    }
}
