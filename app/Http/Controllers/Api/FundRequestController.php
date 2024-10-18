<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Wallet;
use App\Models\ApiToken;
use App\Jobs\BulkPayoutJob;
use App\Models\FundRequest;
use App\Traits\PayoutTraits;
use Illuminate\Http\Request;
use App\Traits\EkoPayoutTrait;
use App\Http\Controllers\Controller;
use App\Models\PayoutRequestHistory;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\FundRequestRequest;
use App\Traits\PayNProPayoutTrait;
use Illuminate\Support\Facades\Log;

class FundRequestController extends Controller
{
    use PayoutTraits,EkoPayoutTrait,PayNProPayoutTrait;
    public function payout(FundRequestRequest $request) {
       $request['user_id'] =  $request->attributes->get('user_id');
       $request['payment_mode'] = getPaymentModesId($request->input('payment_mode'));
    //    $response = $this->payoutApiRequest($request);
    //    $response = $this->ekoPayoutApi($request);;
        $response = $this->payNProPayout($request);
        return $response;
    }



	public function checkStatus(Request $request) {
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

    public function webHookPaynPro(Request $request) {
        if($request['STATUS']=='Success'):
            $FundRequest =FundRequest::where("payout_id", $request['PAYOUT_REF'])->first();
            FundRequest::where('id',$FundRequest->id)->update([
                'status_id'=>'2',
                'payout_ref' =>$request['RRN'],
            ]);
            PayoutRequestHistory::where('fund_request_id',$FundRequest->id)->update([
                'status_id'=>'2',
            ]);
            Log::info("message:-",$request);
        else:
            Log::info("message:-",$request);
        endif;
       
    }   
}
