<?php

namespace App\Http\Helper\Payin;

use Exception;
use GuzzleHttp\Client;
use App\Models\RazorPayLog;

class PhonePe {

    private $apiBaseUrl = "https://api.phonepe.com/apis",$clientId="SU2503201130339526995472",$clientVersion="1",$clientSecret="bb5879b5-d2a5-4cda-9c33-0406ca168838",$grantType="client_credentials",$client;

    public function __construct()
    {
        $this->client = new Client();
    }
    public function initiatePayment($data) {
        try {
            if(now()->timestamp >= session('expires_at')):
                $res = json_decode($this->authorization(),true);
                session([
                    'access_token' => $res['access_token'],
                    'expires_at' => $res['expires_at'],
                ]);
            endif;

            $requestParameter = [
                'merchantOrderId' => $data['order_id'],
                'amount' => $data['amount']*100,
                'paymentFlow' => [
                    'type' => 'PG_CHECKOUT',
                    'message' => 'Payment message used for collect requests',
                    'merchantUrls' => [
                        'redirectUrl' => $data['redirect_url']
                    ]
                ],
                'paymentModeConfig'=>[
                    "enabledPaymentModes"=>[
                        ["type"=>"UPI_INTENT"],
                        ["type"=>"UPI_COLLECT"],
                        ["type"=>"UPI_QR"],

                    ]
                ]
            ];
            // dd($requestParameter);
            $response =  $this->client->post($this->apiBaseUrl.'/pg/checkout/v2/pay', [
                'json' =>  $requestParameter,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'O-Bearer '.session('access_token')
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
        $response = $this->client->post($this->apiBaseUrl.'/identity-manager/v1/oauth/token', [
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

    public function upiIntent($data) {
        try {
            if(now()->timestamp >= session('expires_at')):
                $res = json_decode($this->authorization(),true);
                session([
                    'access_token' => $res['access_token'],
                    'expires_at' => $res['expires_at'],
                ]);
            endif;

            $requestParameter = [
                'merchantOrderId' => $data['order_id'],
                'amount' => $data['payment_amount']*100,
                "expireAfter"=> 1200,
                "deviceContext"=>[
                    "deviceOS"=>'ANDROID'
                ],
                'paymentFlow'=>[
                    "type"=> "PG",
                    "paymentMode" => [
                        "type" => "UPI_INTENT",
                        "targetApp" => "[PHONEPE, GPAY, PAYTM, CRED, BHIM, AMAZON]" // Static Values: PHONEPE, GPAY, PAYTM, CRED, BHIM, AMAZON or null.
                    ]
                ]

            ];

            dd(json_encode($requestParameter));
            $response =  $this->client->post($this->apiBaseUrl.'/pg/payments/v2/pay', [
                'json' =>  $requestParameter,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'O-Bearer '.session('access_token')
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
}