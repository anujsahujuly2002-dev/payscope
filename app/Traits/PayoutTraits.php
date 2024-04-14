<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use App\Models\FundRequest;
use App\Models\PayoutRequestHistory;

trait PayoutTraits {

    protected function payoutApiRequest($data =array()) {
        //check pending fund request
       /*  $checkPendingRequest  = FundRequest::where(['user_id'=>$data['user_id'],'status_id'=>'1'])->count();
        if($checkPendingRequest >0):
            return [
                'status'=>'0001',
                'msg'=>'One request is already submitted'
            ];
        endif; */

        // Check Wallet Amount
        $walletAmount = Wallet::where('user_id',$data['user_id'])->first();
        if($data['amount']+getCommission("dmt",$data['amount'],$data['user_id']) > $walletAmount->amount-$walletAmount->locked_amuont):
            return [
                'status'=>'0002',
                'msg'=>'Low balance to make this request.'
            ];
        endif;

        // Check previous transaction time
        $previousTransactionTimeCheck = FundRequest::where(['user_id'=>$data['user_id'],'account_number'=>$data['account_number'],'amount'=>$data['amount']])->whereBetween('created_at',[Carbon::now()->subSeconds(30)->format('Y-m-d H:i:s'), Carbon::now()->addSeconds(30)->format('Y-m-d H:i:s')])->count();
        if($previousTransactionTimeCheck > 0):
            return [
                'status'=>'0003',
                'msg'=>'Next transaction allowed after 1 Min.'
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
                "bankProfileId" => "24255428726",
                "accountNumber" => "123263400000200"
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
}
