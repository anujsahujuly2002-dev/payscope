<?php

namespace App\Http\Controllers\Api;

<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> edbb7088ad7a904f2f91b646a4572c9f89e9528b
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
<<<<<<< HEAD
use App\Models\User;
=======
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FundRequestRequest;
use App\Models\ApiToken;
use App\Traits\PayoutTraits;
use App\Traits\EkoPayoutTrait;
use Illuminate\Support\Facades\Validator;
>>>>>>> bde5cc6 (again setup)
=======
>>>>>>> edbb7088ad7a904f2f91b646a4572c9f89e9528b

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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> edbb7088ad7a904f2f91b646a4572c9f89e9528b


    public function bulkPayout(Request $request) {
        $checkToken  = ApiToken::where(['ip_address'=>$request->input('ip_address'),'token'=>$request->input('token')])->first();
        if(!$checkToken)
        return response()->json([
            'status'=>false,
            'msg'=>"Invalid Api token or ip address your current ip is ".$request->ip_address
        ],422);
        $request['user_id'] = $checkToken->user_id;
<<<<<<< HEAD
        $checkServiceActive = User::findOrFail($request['user_id'])->services;
        if($checkServiceActive =='0'):
            return [
                'status'=>'0008',
                'msg'=>"This service has been down, Please try again after sometimes",
            ];
        endif;
=======
>>>>>>> edbb7088ad7a904f2f91b646a4572c9f89e9528b
        $request['payment_mode'] = getPaymentModesId($request->input('payment_mode'));
        $orderAmount  = 0;
        $commissionAmount = 0;
        $userDetails = [];
        do {
<<<<<<< HEAD
            $request['payoutid'] = 'GROSC'.rand(111111111111, 999999999999);
        } while (FundRequest::where("payout_id", $request['payoutid'])->first() instanceof FundRequest);
        // dd(count($request->input('userInformation')));
        if(count($request->input('userInformation')) == 1 ):
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
            dispatch(new BulkPayoutJob($userDetails));
            
            return response()->json([
                'status'=>true,
                'transaction_id'=> $request['payoutid'],
                'msg'=>"Transaction Complete successfully,Please hit call back api after one min"
            ],200);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>"Only Allow one transctions sametimes"
            ],422);
        endif;

        
    }

	public function checkStatus(Request $request) {
        $checkToken  = ApiToken::where(['ip_address'=>$request->input('ip_address'),'token'=>$request->input('token')])->first();
        if(!$checkToken)
        return response()->json([
            'status'=>false,
            'msg'=>"Invalid Api token or ip address your current ip is ".$request->ip_address
        ],422);

        $payoutsTransactions = FundRequest::where("payout_id",$request->input('transaction_id'))->get();
        $response = [];
        if($payoutsTransactions->count() >0):
            foreach($payoutsTransactions as $payoutTransaction):
                $response []=[
                    "payout_ref"=>$payoutTransaction->payout_ref,
                    "utr_number"=>trim($payoutTransaction->utr_number),
                    "transaction_id"=>$payoutTransaction->payout_id,
                    'status'=>strip_tags($payoutTransaction->status->name),
                    "account_number"=>$payoutTransaction->account_number,
                    "account_holder_name"=>$payoutTransaction->account_holder_name,
                    "ifsc_code"=>$payoutTransaction->ifsc_code,
                    "amount"=>$payoutTransaction->amount,
                    "charges"=>$payoutTransaction->payoutTransactionHistories->charge
                ];
            endforeach;
        endif;

        return response()->json([
            'status'=>true,
            'msg'=>"You're request has been complete",
            'data'=>$response
        ],200);
    }
=======
>>>>>>> bde5cc6 (again setup)
=======
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
>>>>>>> edbb7088ad7a904f2f91b646a4572c9f89e9528b
}
