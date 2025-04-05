<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use App\Models\FundRequest;
use App\Models\PayoutRequestHistory;
use App\Models\UserWiseService;
use App\Jobs\FundsTransferRequestJob;


trait PayoutTraits {

    protected function payoutApiRequest($data =array()) {
        $checkServiceActive = User::findOrFail($data['user_id'])->services;
        if($checkServiceActive =='0'):
            return [
                'status'=>'0008',
                'msg'=>"This service has been down, Please try again after sometimes",
            ];
        endif;
        // Check Wallet Amount
        $walletAmount = Wallet::where('user_id',$data['user_id'])->first();
        if($data['amount']+getCommission("dmt",$data['amount'],$data['user_id']) > $walletAmount->amount-$walletAmount->locked_amuont):
            return [
                'status'=>'0002',
                'msg'=>'Low balance to make this request.'
            ];
        endif;
            ];
        endif;
        do {
            $data['payoutid'] = 'GROSC'.rand(111111111111, 999999999999);
        } while (FundRequest::where("payout_id", $data['payoutid'])->first() instanceof FundRequest);
        try {
            $fundRequest=FundRequest::create([
                'user_id'=>$data['user_id'],
                'account_number'=>$data['account_number'],
                'account_holder_name'=>$data['account_holder_name'],
                'ifsc_code'=>$data['ifsc_code'],
                'amount'=>$data['amount'],
                'payment_mode_id'=>$data['payment_mode'],
                'status_id'=>'1',
                'type'=>'Bank',
                'pay_type'=>'payout',
                'payout_id'=>$data['payoutid'],
                'payout_ref'=>$data['payoutid']
            ]);
        } catch (\Exception $e) {
            return [
                'status'=>'0004',
                'msg'=>$e->getMessage(),
            ];
        }

        Wallet::where('user_id',$data['user_id'])->update([
            'amount'=>$walletAmount->amount-($data['amount']+getCommission("dmt",$data['amount'],$data['user_id'])),
        ]);
        $adminId = User::whereHas('roles',function($q){
            $q->where('name','super-admin');
        })->first();
        $payoutRequestHistories = PayoutRequestHistory::create([
            'user_id'=>$data['user_id'],
            'fund_request_id'=>$fundRequest->id,
            'api_id'=>'1',
            'amount'=>$data['amount'],
            'charge'=>getCommission("dmt",$data['amount'],$data['user_id']),
            'status_id'=>'1',
            'credited_by'=>$adminId->id,
            'balance'=>$walletAmount->amount,
            'closing_balnce'=>$walletAmount->amount - ($data['amount']+getCommission("dmt",$data['amount'],$data['user_id'])),
            'type'=>"debit",
            'transtype'=>"fund",
            'product'=>'payout',
            'remarks'=>'Bank Settlement'
        ]);
        $url = "https://api.instantpay.in/payments/payout";
        $new_arr[]= unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.request()->ip()));
        $requestParameter = [
            "payer" => [
                "bankProfileId" => "24148428726",
                "accountNumber" => "923020061652668"
            ],
            "payee"   => [
                "name"           => $data['account_holder_name'],
                "accountNumber"  => $data['account_number'],
                "bankIfsc"       => $data['ifsc_code']
            ],

            "transferMode"       => $data['payment_mode']=='1'?"IMPS":"NEFT",
            "transferAmount"     => $data['amount'],
            "externalRef"        =>$data['payoutid'],
            "latitude"           => $new_arr[0]['geoplugin_latitude'],
            "longitude"          => $new_arr[0]['geoplugin_longitude'],
            "remarks"            => 'test',
            "purpose"           => "REIMBURSEMENT",
            "otp"                => "",
            "otpReference"       => ""
        ];

        $headers = [
            'X-Ipay-Auth-Code'=>'1',
            'X-Ipay-Client-Id'=>'YWY3OTAzYzNlM2ExZTJlOUWx2c0hIFCZJmVsLIO8Mxw=',
            'X-Ipay-Client-Secret'=>'051093090b6671f1be11b91eed4091a220c37c51d321f064a25260f6a697114f',
            'X-Ipay-Endpoint-Ip'=>request()->ip(),
            'Content-Type'=>'application/json'
        ];

        $res = apiCall($headers,$url,$requestParameter,true,$data['payoutid']);
        if(isset($res['statuscode']) && in_array($res['statuscode'],['TXN','TUP'])):
            FundRequest::where('id',$fundRequest->id)->update([
                'status_id'=>'2',
                'payout_ref' =>$res['data']['txnReferenceId'],
            ]);
            PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->update([
                'status_id'=>'2',
            ]);
            return [
                'status'=>'0005',
                'msg'=>'Your'.$res['status'],
                'txn_id'=>$data['payoutid'],
                'rrn_no'=>$res['data']['txnReferenceId']
            ];
        else:
            FundRequest::where('id',$fundRequest->id)->update([
                'status_id'=>'3',
            ]);
            PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->update([
                'status_id'=>'3',
                'closing_balnce'=>$walletAmount->amount
            ]);
            Wallet::where('user_id',$data['user_id'])->update([
                'amount'=>$walletAmount->amount,
            ]);
            return [
                'status'=>'0006',
                'msg'=>'Your'.$res['status'],
                'txn_id'=>$data['payoutid']
            ];
        endif;
    }


    // Payout Method

    protected function fundTransfer($data=[]) {
        // dd($data);
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
        $walletAmount = Wallet::where('user_id',$data['user_id'])->first();
        $commissionAndGst = getCommission("payout",$data['amount'],$data['user_id'])['payout_charges']+ getCommission("payout",$data['amount'],$data['user_id'])['gst_charge'];
        $ekoPaymentMode = [
            "imps"=> "5",
            "neft"=>"4",
            "other"=>"13"
        ];
        $closing_balance = $walletAmount->amount-($data['amount']+$commissionAndGst) ;
        $data['reqId'] = $this->generateTransaction();
        addTransactionHistory($data['payoutid'] ,$data['user_id'],($data['amount']+$commissionAndGst),'debit');
        $fundRequest=FundRequest::create([
            'user_id'=>$data['user_id'],
            'order_id'=>$data['order_id'],
            'account_number'=>$data['account_number'],
            'account_holder_name'=>$data['account_holder_name'],
            'ifsc_code'=>$data['ifsc_code'],
            'amount'=>$data['amount'],
            'payment_mode_id'=>$data['payment_mode'],
            'status_id'=>'1',
            'type'=>'Bank',
            'pay_type'=>'payout',
            'quintus_req_id'=>$data['reqId'],
            'creditor_email'=>$data['creditor_email'],
            'creditor_mobile'=>$data['creditor_mobile'],
            'payout_id'=>$data['payoutid'],
        ]);

        $main_amount = $walletAmount->amount;
        $adminId = User::whereHas('roles',function($q){
            $q->where('name','super-admin');
        })->first();
        $payoutRequestHistories = PayoutRequestHistory::create([
            'user_id'=>$data['user_id'],
            'fund_request_id'=>$fundRequest->id,
            'api_id'=>'1',
            'amount'=>$data['amount'],
            'charge'=>getCommission("payout",$data['amount'],$data['user_id'])['payout_charges'],
            'status_id'=>'1',
            'credited_by'=>$adminId->id,
            'balance'=>$main_amount,
            'closing_balnce'=>$closing_balance ,
            'type'=>"debit",
            'transtype'=>"fund",
            'product'=>'payout',
            'remarks'=>'Bank Settlement',
            'payout_api'=>"quintustech",
            'gst'=>getCommission("payout",$data['amount'],$data['user_id'])['gst_charge']
        ]);
        $serializableData = [
            'reqId'=>$data['reqId'],
            'user_id' => $data['user_id'],
            'payoutid'=>$data['payoutid'],
            'amount' => $data['amount'],
            'order_id' => $data['order_id'],
            'account_number' => $data['account_number'],
            'account_holder_name' => $data['account_holder_name'],
            'ifsc_code' => $data['ifsc_code'],
            'payment_mode' => $data['payment_mode'],
            "creditor_mobile"=>$data['creditor_mobile'],
            "creditor_email"=>$data['creditor_email'],
        ];
        FundsTransferRequestJob::dispatch($serializableData)->onQueue('funds-transfers');
        return  [
            'status'=>'0005',
            'statusCode'=>"pending",
            'txn_id'=>$data['payoutid'],
            'order_id'=>$data['order_id']??NULL,
            'msg'=>"Your transaction was successful! We’re now updating your records through our webhook system. Please wait a few moments, and your transaction status will be updated automatically.",
        ];
    }

    private function generateTransaction($length = 35) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Allowed characters
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
