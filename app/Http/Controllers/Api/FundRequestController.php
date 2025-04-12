<?php

namespace App\Http\Controllers\Api;

use App\Models\FundRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PayoutRequestHistory;
use App\Http\Requests\Api\FundRequestRequest;
use Illuminate\Support\Facades\Log;
use  App\Traits\PayoutTraits;
use  App\Traits\EkoPayoutTrait;

class FundRequestController extends Controller
{
    use PayoutTraits,EkoPayoutTrait;

    public function payout(FundRequestRequest $request) {
        $request['user_id'] =  $request->attributes->get('user_id');
        $request['payment_mode'] = getPaymentModesId($request->input('payment_mode'));
        $response = $this->ekoPayoutApi($request);
        return $response;
    }



	public function checkStatus(Request $request) {
        $payoutsTransactions = FundRequest::where("payout_id",$request->input('transaction_id'))->get();
        $response = [];
        if($payoutsTransactions->count() >0):
            foreach($payoutsTransactions as $payoutTransaction):
                $response []=[
                    "payout_ref"=>$payoutTransaction->payout_ref,
                    'order_id'=>$payoutTransaction->order_id,
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
            Log::info('Request data:', $request->all());
            $FundRequest =FundRequest::where("payout_id", $request['PAYOUT_REF'])->first();
            FundRequest::where('id',$FundRequest->id)->update([
                'status_id'=>'2',
                'payout_ref' =>$request['TXN_ID'],
                'utr_number'=>$request['RRN']
            ]);
            PayoutRequestHistory::where('fund_request_id',$FundRequest->id)->update([
                'status_id'=>'2',
            ]);
            // Log::info("message:-".$request);
        else:
           Log::info('Request data:', $request->all());
        endif;

    }
}