<?php

namespace App\Console\Commands;

use App\Models\ApiLog;
use App\Models\Wallet;
use App\Models\FundRequest;
use Illuminate\Console\Command;
use App\Models\PayoutRequestHistory;
use Illuminate\Support\Facades\Http;

class CheckPaymentStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-payment-status-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Payment Status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pendingRequests = FundRequest::where('status_id','1')->where('user_id','9')->orderBy('id','ASC')->get();
        // dd($pendingRequests->count());

        foreach ($pendingRequests as $key1 => $pendingPaymentRequest) :
            $checkApi = ApiLog::where('txn_id',$pendingPaymentRequest->payout_id)->first();
            if(!is_null($checkApi)):
                if($this->url($checkApi->url) =='api.eko.in'):
                    $apiUrl  = 'https://api.eko.in:25002/ekoicici/v1/transactions/client_ref_id:'.$checkApi->txn_id.'?initiator_id=9519035604';
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
                    $response = Http::withHeaders($header)->get($apiUrl);
                    $res = $response->json();
                    echo "Trnasction no:-".($key1+1).PHP_EOL;
                    echo $checkApi->txn_id.PHP_EOL;
                    print_r($res);
                    ApiLog::create([
                        'url'=>$apiUrl,
                        'txn_id'=>$checkApi->txn_id,
                        'header'=>json_encode($header),
                        'request'=>json_encode(['client_ref_id'=>$checkApi->txn_id,'initiator_id'=>'9519035604']),
                        'response'=>json_encode($res)
                    ]);
                    if($res['data']['tx_status']=='4'):
                        $fundRequest=Fundrequest::where('payout_id',$res['data']['client_ref_id'])->first();
                        $fundRequestHistory = PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->first();
                        Fundrequest::where('id',$fundRequest->id)->update([
                            'status_id'=>'4',
                            'payout_ref'=>$res['data']['tid']
                        ]);
                        PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->update([
                            'status_id'=>'4',
                            'closing_balnce'=>$fundRequestHistory->balance
                        ]);
                        $fundRequestHistory = PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->first();
                        $getCurrentWalletAmount =  Wallet::where('user_id',$fundRequest->user_id)->first()->amount;
                        Wallet::where('user_id',$fundRequest->user_id)->update([
                            'amount'=>$fundRequestHistory->amount+$fundRequestHistory->charge+$getCurrentWalletAmount
                        ]);
                    elseif($res['data']['tx_status']=='1'):
                        $fundRequest=Fundrequest::where('payout_id',$checkApi->txn_id)->first();
                        $fundRequestHistory = PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->first();
                        Fundrequest::where('id',$fundRequest->id)->update([
                            'status_id'=>'3',
                            'payout_ref'=>$checkApi->txn_id
                        ]);
                        PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->update([
                            'status_id'=>'3',
                            'closing_balnce'=>$fundRequestHistory->balance
                        ]);
                        // $fundRequestHistory = PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->first();
                        $getCurrentWalletAmount =  Wallet::where('user_id',$fundRequest->user_id)->first()->amount;
                        Wallet::where('user_id',$fundRequest->user_id)->update([
                            'amount'=>$fundRequestHistory->amount+$fundRequestHistory->charge+$getCurrentWalletAmount
                        ]);
                    elseif($res['data']['tx_status']=='0'):
                        $fundRequest=Fundrequest::where('payout_id',$checkApi->txn_id)->first();
                        Fundrequest::where('id',$fundRequest->id)->update([
                            'status_id'=>'2',
                            'payout_ref'=>$res['data']['tid']
                        ]);
                        PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->update([
                            'status_id'=>'2',
                        ]);
                    endif;
                endif;
            else:
                $fundRequestHistory = PayoutRequestHistory::where('fund_request_id',$pendingPaymentRequest->id)->first();
                $fundRequest=Fundrequest::where('payout_id',$pendingPaymentRequest->payout_id)->first();
                Fundrequest::where('id',$fundRequest->id)->update([
                    'status_id'=>'3',
                    'payout_ref'=>$pendingPaymentRequest->txnpayout_id_id,
                ]);
                PayoutRequestHistory::where('fund_request_id',$fundRequest->id)->update([
                    'status_id'=>'3',
                    'closing_balnce'=>$fundRequestHistory->balance
                ]);
               
                $getCurrentWalletAmount =  Wallet::where('user_id',$fundRequest->user_id)->first()->amount;
                Wallet::where('user_id',$fundRequest->user_id)->update([
                    'amount'=>$fundRequestHistory->amount+$fundRequestHistory->charge+$getCurrentWalletAmount
                ]);
            endif;
        endforeach;
    }

    private function url($url) {
        $result = parse_url($url);
        return $result['host'];
    }
}
