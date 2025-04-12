<?php

namespace App\Jobs;

use App\Models\PaymentMode;
use App\Models\Wallet;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Helper\Payout\QuintusPayoutPayment;
use App\Models\FundRequest;
use App\Models\PayoutRequestHistory;
use App\Models\User;

class FundsTransferRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    public $requestParamater;
    public function __construct(array $requestParameter)
    {
        $this->requestParamater = $requestParameter;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // $quintusPayoutPayment  = New QuintusPayoutPayment();
        // Log::info($quintusPayoutPayment->makePayment($this->requestParamater));
         try{
            $walletAmount = Wallet::where('user_id',$this->requestParamater['user_id'])->first();
            $commissionAndGst = getCommission("payout",$this->requestParamater['amount'],$this->requestParamater['user_id'])['payout_charges']+ getCommission("payout",$this->requestParamater['amount'],$this->requestParamater['user_id'])['gst_charge'];
            if($this->requestParamater['amount']+$commissionAndGst > ($walletAmount->amount-$walletAmount->locked_amuont)):
                Log::info(['message'=>'Low balance to make this request.','transaction_id'=>$this->requestParamater['payoutid']]);
                return false;
            endif;
            $ekoPaymentMode = [
                "imps"=> "5",
                "neft"=>"4",
                "other"=>"13"
            ];
            $apiUrl = "https://api.eko.in:25002/ekoicici/v1/agent/user_code:33995001/settlement";
            $key = "1e4a4d07-996a-4efb-a8e4-c142b535e08b";
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
            $walletAmount = Wallet::where('user_id',$this->requestParamater['user_id'])->first();
            $commissionAndGst = getCommission("payout",$this->requestParamater['amount'],$this->requestParamater['user_id'])['payout_charges']+ getCommission("payout",$this->requestParamater['amount'],$this->requestParamater['user_id'])['gst_charge'];
            $closing_balance = $walletAmount->amount-($this->requestParamater['amount']+$commissionAndGst) ;
            addTransactionHistory($this->requestParamater['payoutid'] ,$this->requestParamater['user_id'],($this->requestParamater['amount']+$commissionAndGst),'debit');


            $fundRequest=FundRequest::create([
                'user_id'=>$this->requestParamater['user_id'],
                'order_id'=>$this->requestParamater['order_id'],
                'account_number'=>$this->requestParamater['account_number'],
                'account_holder_name'=>$this->requestParamater['account_holder_name'],
                'ifsc_code'=>$this->requestParamater['ifsc_code'],
                'amount'=>$this->requestParamater['amount'],
                'payment_mode_id'=>$this->requestParamater['payment_mode'],
                'status_id'=>'1',
                'type'=>'Bank',
                'pay_type'=>'payout',
                'payout_id'=>$this->requestParamater['payoutid'],
            ]);

            $main_amount = $walletAmount->amount;
            $adminId = User::whereHas('roles',function($q){
                $q->where('name','super-admin');
            })->first();
            $payoutRequestHistories = PayoutRequestHistory::create([
                'user_id'=>$this->requestParamater['user_id'],
                'fund_request_id'=>$fundRequest->id,
                'api_id'=>'1',
                'amount'=>$this->requestParamater['amount'],
                'charge'=>getCommission("payout",$this->requestParamater['amount'],$this->requestParamater['user_id'])['payout_charges'],
                'status_id'=>'1',
                'credited_by'=>$adminId->id,
                'balance'=>$main_amount,
                'closing_balnce'=>$closing_balance ,
                'type'=>"debit",
                'transtype'=>"fund",
                'product'=>'payout',
                'remarks'=>'Bank Settlement',
                'payout_api'=>"eko",
                'gst'=>getCommission("payout",$this->requestParamater['amount'],$this->requestParamater['user_id'])['gst_charge']
            ]);
            $new_arr[]= unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.request()->ip()));
            $requestParameter = 'initiator_id=9519035604&amount='.$this->requestParamater['amount'].'&payment_mode='.$ekoPaymentMode[$this->getPaymentModesName($this->requestParamater['payment_mode'])].'&client_ref_id='.$this->requestParamater['payoutid'].'&recipient_name='.$this->requestParamater['account_holder_name'].'&ifsc='.$this->requestParamater['ifsc_code'].'&account='.$this->requestParamater['account_number'].'&service_code=45&sender_name=test&source=NEWCONNECT&tag=Logistic&beneficiary_account_type=1';
            $res = apiCallWitBody($header,$apiUrl,$requestParameter,true,$this->requestParamater['payoutid']);
            if(isset($res['data'])):
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
                            else:
                                FundRequest::where('id',$fundRequest->id)->update([
                                    'status_id'=>'1',
                                    'payout_ref' =>$res['data']['tid'],
                                    'utr_number' =>$res['data']['bank_ref_num'],
                                ]);
                                PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->update([
                                    'status_id'=>'1',
                                ]);
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
                        endif;
                    else:
                        addTransactionHistory($this->requestParamater['payoutid'] ,$this->requestParamater['user_id'],($this->requestParamater['amount']+$commissionAndGst),'credit');
                        FundRequest::where('id',$fundRequest->id)->update([
                            'status_id'=>'3',
                        ]);
                        PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->update([
                            'status_id'=>'3',
                            'closing_balnce'=>$closing_balance+$this->requestParamater['amount']+$commissionAndGst,
                        ]);
                    endif;
                }else{
                    addTransactionHistory($this->requestParamater['payoutid'] ,$this->requestParamater['user_id'],($this->requestParamater['amount']+$commissionAndGst),'credit');
                    FundRequest::where('id',$fundRequest->id)->update([
                        'status_id'=>'3',
                    ]);
                    PayoutRequestHistory::where('id',$fundRequest->id)->update([
                        'status_id'=>'3',
                        'closing_balnce'=>$closing_balance+$this->requestParamater['amount']+$commissionAndGst
                    ]);
                }
            else:
                addTransactionHistory($this->requestParamater['payoutid'] ,$this->requestParamater['user_id'],($this->requestParamater['amount']+$commissionAndGst),'credit');
                FundRequest::where('id',$fundRequest->id)->update([
                    'status_id'=>'3',
                ]);
                PayoutRequestHistory::where('id',$fundRequest->id)->update([
                    'status_id'=>'3',
                    'closing_balnce'=>$closing_balance+$this->requestParamater['amount']+$commissionAndGst
                ]);
            endif;
        }catch (Exception $e) {
            Log::info(['message'=>$e->getMessage(),'transaction_id'=>$this->requestParamater['payoutid']]);
            return false;
        }

    }

    private function getPaymentModesName($data) {
        return  PaymentMode::find($data)->name;
    }
}
