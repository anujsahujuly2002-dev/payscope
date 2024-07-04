<?php

namespace App\Jobs;

use Exception;
use App\Models\User;
use App\Models\Wallet;
use App\Models\FundRequest;
use Illuminate\Bus\Queueable;
use App\Traits\EkoPayoutTrait;
use Illuminate\Support\Facades\Log;
use App\Models\PayoutRequestHistory;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BulkPayoutJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,EkoPayoutTrait;

    /**
     * Create a new job instance.
     */

    protected $user;
    public function __construct($userInformation)
    {
        $this->user = $userInformation;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
<<<<<<< HEAD
        foreach($this->user as $userInfo):
=======
        // dd("dsd",$this->user);
        foreach($this->user as $userInfo):
            // dd($userInfo);
>>>>>>> edbb7088ad7a904f2f91b646a4572c9f89e9528b
            $ekoPaymentMode = [
                "imps"=> "5",
                "neft"=>"4",
                "other"=>"13"
            ];
            $walletAmount = Wallet::where('user_id',$userInfo['user_id'])->first();
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
           
            try{
                $fundRequest=FundRequest::create([
                    'user_id'=>$userInfo['user_id'],
                    'account_number'=>$userInfo['account_number'],
                    'account_holder_name'=>$userInfo['account_holder_name'],
                    'ifsc_code'=>$userInfo['ifsc_code'],
                    'amount'=>$userInfo['amount'],
                    'payment_mode_id'=>$userInfo['payment_mode'],
                    'status_id'=>'1',
                    'type'=>'Bank',
                    'pay_type'=>'payout',
                    'payout_id'=>$userInfo['payoutid'],
<<<<<<< HEAD
                    'payout_ref'=>$userInfo['payoutid'],
                    'payment_type'=>"0",
=======
                    'payout_ref'=>$userInfo['payoutid']
>>>>>>> edbb7088ad7a904f2f91b646a4572c9f89e9528b
                ]);
            }catch (Exception $e){
               Log::error([ 'status'=>'0004', 'msg'=>$e->getMessage()]);
                
            }
            $main_amount = $walletAmount->amount;
            $closing_balance = $walletAmount->amount-($userInfo['amount']+getCommission("dmt",$userInfo['amount'],$userInfo['user_id']));
            Wallet::where('user_id',$userInfo['user_id'])->update([
                'amount'=>$walletAmount->amount-($userInfo['amount']+getCommission("dmt",$userInfo['amount'],$userInfo['user_id'])),
            ]);
    
            $adminId = User::whereHas('roles',function($q){
                $q->where('name','super-admin');
            })->first();
            $payoutRequestHistories = PayoutRequestHistory::create([
                'user_id'=>$userInfo['user_id'],
                'fund_request_id'=>$fundRequest->id,
                'api_id'=>'1',
                'amount'=>$userInfo['amount'],
                'charge'=>getCommission("dmt",$userInfo['amount'],$userInfo['user_id']),
                'status_id'=>'1',
                'credited_by'=>$adminId->id,
                'balance'=>$main_amount,
                'closing_balnce'=>$closing_balance ,
                'type'=>"debit",
                'transtype'=>"fund",
                'product'=>'payout',
                'remarks'=>'Bank Settlement'
            ]);
            $new_arr[]= unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.request()->ip()));
            $requestParameter = 'initiator_id=9519035604&amount='.$userInfo['amount'].'&payment_mode='.$ekoPaymentMode[$this->getPaymentModesName($userInfo['payment_mode'])].'&client_ref_id='.$userInfo['payoutid'].'&recipient_name='.$userInfo['account_holder_name'].'&ifsc='.$userInfo['ifsc_code'].'&account='.$userInfo['account_number'].'&service_code=45&sender_name=test&source=NEWCONNECT&tag=Logistic&beneficiary_account_type=1';
            $res = apiCallWitBody($header,$apiUrl,$requestParameter,true,$userInfo['payoutid']);
            if($res['data'] != ""){
                if(isset($res['status']) && $res['status']=='0' && $res['response_status_id']=='0'):
                    FundRequest::where('id',$fundRequest->id)->update([
                        'status_id'=>'2',
                        'payout_ref' =>$res['data']['tid'],
                        'utr_number' =>$res['data']['bank_ref_num'],
                    ]);
                    PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->update([
                        'status_id'=>'2',
                    ]);
                else:
                    FundRequest::where('id',$fundRequest->id)->update([
                        'status_id'=>'3',
                    ]);
                    PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->update([
                        'status_id'=>'3',
                        'closing_balnce'=>$walletAmount->amount
                    ]);
                    Wallet::where('user_id',$userInfo['user_id'])->update([
                        'amount'=>$walletAmount->amount,
                    ]);
                  
                endif;
            }else{
                FundRequest::where('id',$fundRequest->id)->update([
                    'status_id'=>'3',
                ]);
                PayoutRequestHistory::where('id',$fundRequest->id)->update([
                    'status_id'=>'3',
                    'closing_balnce'=>$walletAmount->amount
                ]);
                Wallet::where('user_id',$userInfo['user_id'])->update([
                    'amount'=>$walletAmount->amount,
                ]);
            }
        endforeach;
    }
}
