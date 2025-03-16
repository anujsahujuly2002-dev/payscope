<?php 

namespace App\Http\Helper\Payin;

use Exception;
use GuzzleHttp\Client;
use App\Models\RazorPayLog;

class PhonePe {

    private $apiBaseUrl = "https://api-preprod.phonepe.com/apis/pg-sandbox",$clientId="GROSCOPEUAT_2412031530167115053547",$clientVersion="1",$clientSecret="MjYxODE3OWQtMmE1Zi00MWZlLWI5Y2ItOWRjZGFlZGUxZmIw",$grantType="client_credentials",$client;

    public function __construct()
    {
        $this->client = new Client();
    }
    public function initiatePayment($data) {
        try {
            $res = json_decode($this->authorization(),true);
            $requestParameter = [
                'merchantOrderId' => $data['order_id'],
                'amount' => $data['amount']*100,
                'paymentFlow' => [
                    'type' => 'PG_CHECKOUT',
                    'message' => 'Payment message used for collect requests',
                    'merchantUrls' => [
                        'redirectUrl' => route('admin.payment.collection.phone.callback')
                    ]
                ]
            ];
            // dd($requestParameter);
            $response =  $this->client->post($this->apiBaseUrl.'/checkout/v2/pay', [
                'json' =>  $requestParameter,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'O-Bearer '.$res['access_token']
                ]
            ]);
            $results =$response->getBody()->getContents();
            RazorPayLog::create([
                'user_id'=>$data['user_id'],
                'type'=>"initiate_payment",
                'request'=>json_encode($requestParameter),
                'response'=>($results),
            ]);
            return [
                'status'=>true,
                "data"=>json_decode($results,true),
            ];
        }catch (Exception $e){
            return [
                'status'=>false,
                "message"=>$e->getMessage(),
            ];
        
        }
        
        
    }   

    private function authorization() {
        $response = $this->client->post($this->apiBaseUrl.'/v1/oauth/token', [
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