<?php

namespace App\Traits;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use App\Models\FundRequest;
use App\Models\PaymentMode;
use App\Models\PayoutRequestHistory;

trait EkoPayoutTrait {

    protected function ekoPayoutApi($data=array()) {
        $ekoPaymentMode = [
            "imps"=> "5",
            "neft"=>"4",
            "other"=>"13"
        ];
        $apiUrl = "https://api.eko.in:25002/ekoicici/v1/agent/user_code:33995001/settlement";
        $key = "7865654c-2149-40d3-a184-aff404864a68";
        $encodedKey = base64_encode($key);
        $secret_key_timestamp =round(microtime(true) * 1000);
        $signature = hash_hmac('SHA256', $secret_key_timestamp, $encodedKey, true);
        $secret_key = base64_encode($signature);
        $header=array(
            "developer_key"=>"a9a9bd9975d8237cdfc8a4ccdca33d0e",
            "secret-key"=>$secret_key,
            "secret-key-timestamp"=>$secret_key_timestamp,
            "Content-Type"=>"application/x-www-form-urlencoded"
        );
        $checkServiceActive = User::findOrFail($data['user_id'])->services;
        if($checkServiceActive =='0'):
            return [
                'status'=>'0008',
                'msg'=>"This service has been down, Please try again after sometimes",
            ];
        endif;
        $walletAmount = Wallet::where('user_id',$data['user_id'])->first();
        if($data['amount']+getCommission("dmt",$data['amount'],$data['user_id']) > ($walletAmount->amount-$walletAmount->locked_amuont)):
            return [
                'status'=>'0002',
                'msg'=>'Low balance to make this request.'
            ];
        endif;
        // Check previous transaction time
        $previousTransactionTimeCheck = FundRequest::where(['user_id'=>$data['user_id']])->whereBetween('created_at',[Carbon::now()->subSeconds(10)->format('Y-m-d H:i:s'), Carbon::now()->addSeconds(10)->format('Y-m-d H:i:s')])->count();
        if($previousTransactionTimeCheck > 0):
            return [
                'status'=>'0003',
                'msg'=>'Next transaction allowed after 4 sec.'
            ];
        endif;
        do {
            $data['payoutid'] = 'GROSC'.rand(111111111111, 999999999999);
        } while (FundRequest::where("payout_id", $data['payoutid'])->first() instanceof FundRequest);
        try{
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
        }catch (Exception $e){
            return [
                'status'=>'0004',
                'msg'=>$e->getMessage(),
            ];
        }
        $main_amount = $walletAmount->amount;
        $closing_balance = $walletAmount->amount-($data['amount']+getCommission("dmt",$data['amount'],$data['user_id']))+calculateGst($data['amount']);
        Wallet::where('user_id',$data['user_id'])->update([
            // 'amount'=>$walletAmount->amount-($data['amount']+getCommission("dmt",$data['amount'],$data['user_id'])),
            'amount'=>$closing_balance ,
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
            'balance'=>$main_amount,
            'closing_balnce'=>$closing_balance ,
            'type'=>"debit",
            'transtype'=>"fund",
            'product'=>'payout',
            'remarks'=>'Bank Settlement',
            'payout_api'=>"eko",
            'gst'=>calculateGst($data['amount'])
        ]);
        addTransactionHistory($data['payoutid'] ,$data['user_id'],($data['amount']+getCommission("dmt",$data['amount'],$data['user_id']))+calculateGst($data['amount']),'debit');
        $new_arr[]= unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.request()->ip()));
        $requestParameter = 'initiator_id=9519035604&amount='.$data['amount'].'&payment_mode='.$ekoPaymentMode[$this->getPaymentModesName($data['payment_mode'])].'&client_ref_id='.$data['payoutid'].'&recipient_name='.$data['account_holder_name'].'&ifsc='.$data['ifsc_code'].'&account='.$data['account_number'].'&service_code=45&sender_name=test&source=NEWCONNECT&tag=Logistic&beneficiary_account_type=1';
        $res = apiCallWitBody($header,$apiUrl,$requestParameter,true,$data['payoutid']);
        if($res['data'] != ""){
            if(isset($res['status']) && $res['status']=='0' && $res['response_status_id']=='0'):
                if($res['data']['tx_status']=='0'):
                    if($res['data']['bank_ref_num'] !=''):
                        FundRequest::where('id',$fundRequest->id)->update([
                            'status_id'=>'2',
                            'payout_ref' =>$res['data']['tid'],
                            'utr_number' =>$res['data']['bank_ref_num'],
                        ]);
                        PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->update([
                            'status_id'=>'2',
                        ]);
                        return  [
                            'status'=>'0005',
                            'statusCode'=>"pending",
                            'txn_id'=>$data['payoutid'],
                            'msg'=>"Your transaction was successful! We’re now updating your records through our webhook system. Please wait a few moments, and your transaction status will be updated automatically.",
                        ];
                    else:
                        FundRequest::where('id',$fundRequest->id)->update([
                            'status_id'=>'1',
                            'payout_ref' =>$res['data']['tid'],
                            'utr_number' =>$res['data']['bank_ref_num'],
                        ]);
                        PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->update([
                            'status_id'=>'1',
                        ]);
                        return  [
                            'status'=>'0005',
                            'statusCode'=>"pending",
                            'txn_id'=>$data['payoutid'],
                            'msg'=>"Your transaction was successful! We’re now updating your records through our webhook system. Please wait a few moments, and your transaction status will be updated automatically.",
                        ];
                    endif;
                   
                else:
                    FundRequest::where('id',$fundRequest->id)->update([
                        'status_id'=>'1',
                        'payout_ref' =>$res['data']['tid'],
                        'utr_number' =>$res['data']['bank_ref_num'],
                    ]);
                    PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->update([
                        'status_id'=>'1',
                    ]);
                    return  [
                        'status'=>'0005',
                        'statusCode'=>"pending",
                        'txn_id'=>$data['payoutid'],
                        'msg'=>"Your transaction was successful! We’re now updating your records through our webhook system. Please wait a few moments, and your transaction status will be updated automatically.",
                    ];
                endif;                
            else:
                FundRequest::where('id',$fundRequest->id)->update([
                    'status_id'=>'3',
                ]);
                PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->update([
                    'status_id'=>'3',
                    // 'closing_balnce'=>$walletAmount->amount
                    'closing_balnce'=>$closing_balance+$data['amount']+getCommission("dmt",$data['amount'],$data['user_id']),
                ]);
                Wallet::where('user_id',$data['user_id'])->update([
                    // 'amount'=>$walletAmount->amount,
                    'amount'=>$main_amount,
                ]);
                return [
                    'status'=>'0006',
                    'msg'=>'Your'.$res['status'],
                    'txn_id'=>$data['payoutid']
                ];
            endif;
        }else{
            FundRequest::where('id',$fundRequest->id)->update([
                'status_id'=>'3',
            ]);
            PayoutRequestHistory::where('id',$fundRequest->id)->update([
                'status_id'=>'3',
                // 'closing_balnce'=>$walletAmount->amount
                'closing_balnce'=>$closing_balance+$data['amount']+getCommission("dmt",$data['amount'],$data['user_id'])
            ]);
            Wallet::where('user_id',$data['user_id'])->update([
                // 'amount'=>$walletAmount->amount,
                'amount'=>$main_amount,
            ]);
            return [
                'status'=>'0007',
                'msg'=>"You're transaction is faild, Please try again",
                'txn_id'=>$data['payoutid']
            ];
        }




    }


    private function getPaymentModesName($data) {
        return  PaymentMode::find($data)->name;
    }

}
