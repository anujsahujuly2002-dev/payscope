<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Exception;
use GuzzleHttp\Client;
use App\Models\QRPaymentCollection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Jobs\PaymentCollectionCallbackJob;

class CheckStatusPhonePeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-status-phone-pe-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Status api';

    /**
     * Execute the console command.
     */

    private $apiBaseUrl = "https://api.phonepe.com/apis",$clientId="SU2503201130339526995472",$clientVersion="1",$clientSecret="bb5879b5-d2a5-4cda-9c33-0406ca168838",$grantType="client_credentials",$client;
    public function handle()
    {
        try {
            $client = new Client();
            if(now()->timestamp >= session('expires_at')):
                $res = json_decode($this->authorization(),true);
                session([
                    'access_token' => $res['access_token'],
                    'expires_at' => $res['expires_at'],
                ]);
            endif;
            $getPendingPayments = QRPaymentCollection::where(['payment_channel'=>'phone-pe','status_id'=>'1'])->get();
            foreach($getPendingPayments  as $pendingStatus):
                // $logs = DB::table('razor_pay_logs')
                // ->whereRaw("JSON_EXTRACT(response, '$.orderId') = ?", [$pendingStatus->qr_code_id])
                // ->first();
                // $ordeer = json_decode($logs->request,true);
                $response = Http::withHeaders([
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'O-Bearer ' . session('access_token'),
                ])->get("https://api.phonepe.com/apis/pg/checkout/v2/order/{$pendingStatus->order_id}/status?details=true&errorContext=true");
                $results = json_decode($response->getBody()->getContents(), true);
                if(array_key_exists('success',$results)&&$results['success'] ===false && $results['code'] ==='ORDER_NOT_FOUND'):
                    $pendingStatus->update([
                        'qr_status'=>'closed',
                        'status_id'=>"3",
                        'close_reason'=> ucwords(str_replace('_', ' ', $results['message'])),
                    ]);
                elseif(array_key_exists('state',$results) && $results['state'] ==='COMPLETED'):
                    if(array_key_exists('state',$results['paymentDetails'][0]) && $results['paymentDetails'][0]['state'] ==='FAILED'):
                        $pendingStatus->update([
                            'payments_amount_received' => $results['payableAmount'] / 100,
                            'status_id' =>  "3",
                            'utr_number' => $results['paymentDetails'][1]['rail']['utr'],
                            'payment_id' => $results['paymentDetails'][1]['rail']['upiTransactionId'],
                            'close_reason'=> ucwords(str_replace('_', ' ', $results['paymentDetails'][0]['detailedErrorCode']))
                        ]);
                    else:
                        $pendingStatus->update([
                            'payments_amount_received' => $results['payableAmount'] / 100,
                            'status_id' => ($results['state'] === 'COMPLETED') ? '2' : "3",
                            'utr_number' => $results['paymentDetails'][0]['rail']['utr'],
                            'payment_id' => $results['paymentDetails'][0]['rail']['upiTransactionId'],
                            
                        ]);
                    endif;
                    $paymentCollection = QRPaymentCollection::where('qr_code_id', $results['orderId'])->with('status')->first();
                    if ($paymentCollection) :
                        PaymentCollectionCallbackJob::dispatch($paymentCollection->toArray())->onQueue('payment-collection-success');
                    endif;
                elseif(array_key_exists('state',$results) && $results['state'] ==='FAILED'):
                    $pendingStatus->update([
                        'qr_status'=>'closed',
                        'status_id'=>"3",
                        'close_reason'=> ucwords(str_replace('_', ' ', $results['errorContext']['description'])),
                    ]);
                    $paymentCollection = QRPaymentCollection::where('qr_code_id', $results['orderId'])->with('status')->first();
                    if ($paymentCollection) :
                        PaymentCollectionCallbackJob::dispatch($paymentCollection->toArray())->onQueue('payment-collection-success');
                    endif;
                else:
                    print_r($results);
                endif;
                
            endforeach;
           
        }catch (Exception $e){
            print_r($results);
            echo $e->getMessage().PHP_EOL;
        }

      
        
    }

    private function authorization() {
        $client = new Client();
        $response =$client->post($this->apiBaseUrl.'/identity-manager/v1/oauth/token', [
            'form_params' => [
                'client_id' => $this->clientId,
                'client_version' => $this->clientVersion,
                'client_secret' => $this->clientSecret,
                'grant_type' =>  $this->grantType
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ]);
        return $response->getBody()->getContents();
    }
}
