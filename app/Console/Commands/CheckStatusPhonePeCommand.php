<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Exception;
use GuzzleHttp\Client;
use App\Models\QRPaymentCollection;
use Illuminate\Support\Facades\Http;

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
            $getPendingPayments = QRPaymentCollection::where(['payment_channel'=>'phone-pe'])->get();
            foreach($getPendingPayments  as $pendingStatus):
                $response = Http::withHeaders([
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'O-Bearer ' . session('access_token'),
                ])->get("https://api.phonepe.com/apis/pg/checkout/v2/order/{$pendingStatus->qr_code_id}/status?details=true&errorContext=true");


                // Decode JSON response
                $results = json_decode($response->getBody(), true);
                // dd($results['success'], $results['code']);
                if($results['success'] ===false && $results['code'] ==='ORDER_NOT_FOUND'):
                    print_r($results);
                    // QRPaymentCollection::where->update([
                    //     'qr_status'=>'closed',
                    //     'status_id'=>"3",
                    //     'close_reason'=> ucwords(str_replace('_', ' ', $results['message'])),
                    // ]);
                else:
                    dd($results);
                endif;
                
            endforeach;
           
        }catch (Exception $e){
            return [
                'status'=>false,
                "message"=>$e->getMessage(),
            ];

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
