<?php 

namespace App\Traits;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use App\Models\FundRequest;
use App\Models\PayoutRequestHistory;

trait PayNProPayoutTrait {

    protected function payNProPayout($data) {
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
        // Check previous transaction time
        $previousTransactionTimeCheck = FundRequest::where(['user_id'=>$data['user_id'],'account_number'=>$data['account_number']])->whereBetween('created_at',[Carbon::now()->subSeconds(3)->format('Y-m-d H:i:s'), Carbon::now()->addSeconds(3)->format('Y-m-d H:i:s')])->count();
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
            'remarks'=>'Bank Settlement',
            'payout_api'=>"paynpro"
        ]);


        $apiUrl ="https://pout.paynpro.com/payout/v1/transfer";
        $salt ="mIfBc8Iub3sOEyUS"; // Salt Key
        $secret = "mXRhX1lk5jTYxJZD"; // Encryption Key
        $checkServiceActive = User::findOrFail($data['user_id']);
        if($checkServiceActive->services =='0'):
            return [
                'status'=>'0008',
                'msg'=>"This service has been down, Please try again after sometimes",
            ];
        endif;
        $headers = [
            'X-APIKEY'=>'NAAPIB16hn9gFd2nmC8nc',
            'X-APISECRET'=>$secret,
        ];

        $requestParameter = [
            'username'=>$checkServiceActive->name,
            'email_id'=>$checkServiceActive->email,
            'mob_no'=>$checkServiceActive->mobile_no,
            'amount'=>$data['amount'],
            'payout_ref'=>$data['payoutid'],
            'txn_type'=>'IMPS',
            'recv_bank_ifsc'=>$data['ifsc_code'],
            'recv_name'=>trim($data['account_holder_name']),
            'recv_bank_name'=>trim($data['account_name']),
            'purpose'=>"Rembirsment",
            'recv_acc_no'=>trim($data['account_number']),
            'udf1'=>"",
            'udf2'=>"",
            'udf3'=>"",
            'udf4'=>"",
            'udf5'=>"",
        ];
        $requestParameter['signature'] = $this->getSignature($checkServiceActive->name,$checkServiceActive->email,$checkServiceActive->mobile_no,$data['amount']);
        $res = apiCall($headers,$apiUrl,$requestParameter,true,$data['payoutid']);
        if(!array_key_exists('status',$res)):
            return  [
                'status'=>'0005',
                'statusCode'=>"pending",
                'txn_id'=>$data['payoutid'],
                'msg'=>"Your transaction was successful! We’re now updating your records through our webhook system. Please wait a few moments, and your transaction status will be updated automatically.",
            ];
        else:
            return  [
                'status'=>'0008',
                'txn_id'=>$data['payoutid'],
                'msg'=>$res['msg'],
            ];
        endif;
        

    }

    private function encrypt($data, $salt,$key) {
        if($key != NULL && $data != "" && $salt != ""){
        $method = "AES-256-CBC";
        /*Converting Array to bytes*/
        $iv = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
        $chars = array_map("chr", $iv);
        $IVbytes = join($chars);
        $salt1 = mb_convert_encoding($salt, "UTF-8"); /*Encoding to UTF-8*/
        $key1 = mb_convert_encoding($key, "UTF-8"); /*Encoding to UTF-8*/
        /*SecretKeyFactory Instance of PBKDF2WithHmacSHA1 Java Equivalent*/
        $hash = openssl_pbkdf2($key1,$salt1,'256','65536', 'sha1');
        $encrypted = openssl_encrypt($data, $method, $hash, OPENSSL_RAW_DATA,
        $IVbytes);
        return bin2hex($encrypted);
        }else{
        return "String to encrypt, Salt and Key is required.";
        } 
    }

    private function decrypt($data="", $salt = "", $key = NULL) {
        if($key != NULL && $data != "" && $salt != ""){
            $dataEncypted = hex2bin($data);
            $method = "AES-256-CBC";
            /*Converting Array to bytes*/
            $iv = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
            $chars = array_map("chr", $iv);
            $IVbytes = join($chars);
            $salt1 = mb_convert_encoding($salt, "UTF-8");/*Encoding to UTF-8*/
            $key1 = mb_convert_encoding($key, "UTF-8");/*Encoding to UTF-8*/
            /*SecretKeyFactory Instance of PBKDF2WithHmacSHA1 Java Equivalent*/
            $hash = openssl_pbkdf2($key1,$salt1,'256','65536', 'sha1');
            $decrypted = openssl_decrypt($dataEncypted, $method, $hash,
            OPENSSL_RAW_DATA, $IVbytes);
            return $decrypted;
        }else{
            return "Encrypted String to decrypt, Salt and Key is required.";
        }
    }

    public function getSignature()
    {
        $message = "NAAPIB16hn9gFd2nmC8nc"."mXRhX1lk5jTYxJZD";

        // to lowercase hexits
        $signature =hash_hmac('sha256', $message, "9Wq3PxKeY5ABrnHN");
        return $signature;
    }
}