<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Wallet;
use App\Models\FundRequest;
use App\Jobs\FundsTransferRequestJob;
use App\Models\UserWiseService;
use Carbon\Carbon;

trait EkoPayoutTrait {

    protected function ekoPayoutApi($data=array()) {
        $checkServiceActive = UserWiseService::where('user_id',$data['user_id'])->first();
        if(is_null($checkServiceActive) ||$checkServiceActive->payout =='0'):
            return [
                'status'=>'0008',
                'msg'=>"This service has been down, Please try again after sometimes",
            ];
        endif;
        $walletAmount = Wallet::where('user_id',$data['user_id'])->first();
        $commissionAndGst = getCommission("payout",$data['amount'],$data['user_id'])['payout_charges']+ getCommission("payout",$data['amount'],$data['user_id'])['gst_charge'];
        if($data['amount']+$commissionAndGst > ($walletAmount->amount-$walletAmount->locked_amuont)):
            return [
                'status'=>'0002',
                'msg'=>'Low balance to make this request.'
            ];
        endif;
        // Check previous transaction time
        do {
            $data['payoutid'] = 'GROSC'.rand(111111111111, 999999999999);
        } while (FundRequest::where("payout_id", $data['payoutid'])->first() instanceof FundRequest);
        // Ensure only serializable data is passed
        $serializableData = [
            'user_id' => $data['user_id'],
            'payoutid'=>$data['payoutid'],
            'amount' => $data['amount'],
            'order_id' => $data['order_id'],
            'account_number' => $data['account_number'],
            'account_holder_name' => $data['account_holder_name'],
            'ifsc_code' => $data['ifsc_code'],
            'payment_mode' => $data['payment_mode'],
        ];

        FundsTransferRequestJob::dispatch($serializableData)->onQueue('funds-transfers')->delay(Carbon::now()->addSeconds(3));
        return  [
            'status'=>'0005',
            'statusCode'=>"pending",
            'txn_id'=>$data['payoutid'],
            'order_id'=>$data['order_id']??NULL,
            'msg'=>"Your transaction was successful! We’re now updating your records through our webhook system. Please wait a few moments, and your transaction status will be updated automatically.",
        ];
    }
}
