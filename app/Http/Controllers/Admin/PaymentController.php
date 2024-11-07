<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use Razorpay\Api\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Razorpay\Api\Errors\BadRequestError;

class PaymentController extends Controller
{
    protected $api;

    public function __construct()
    {
        $this->api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    }

    public function index(){
        $order = $this->createOrder(10);
        dd($order);
        try{

            $intent= $this->api->payment->createUpi(array(
                "amount" => $order['amount'],
                "currency" => "INR",
                "order_id" => $order['id'],
                "email" =>  "nicknikhilyadavnieck@gmail.com",
                "contact" => "6386565743",
                "method" => "upi",
                "customer_id" => "cust_P9lEOdEtSHA1FT",
                "ip" => "106.219.152.38",
                "referer" => "http",
                "user_agent" => "Mozilla/5.0",
                "description" => "Test flow",
                "notes" => array("note_key" => "value1"),
                "upi" => array(
                    "flow" => "intent"
                )
            ));
            dd($intent);
        }catch(Exception $e) {
            dd($e);

        }
    }

    public function createOrder($amount, $currency = 'INR')
    {
        return $this->api->order->create(array(
            'amount' => 100, 
            'method' => 'upi',
            'currency' => 'INR',
            'bank_account'=> array(
                'account_number'=> '3336359309',
                'name'=> 'NIKHIL KUMAR',
                'ifsc'=>'CBIN0284533'
            )
        ));
        
    }

    public function generateQrCode($orderId)
    {
        try{
            return $this->api->paymentLink->create([
                'type' => 'link',
                'order_id' => $orderId,
                'view_qr' => 1
            ]);
        }catch(Exception $e) {
            dd($e);
        }
        
    }


    public function createCustomer() {
        $customer = $this->api->customer->create(
            array(
                'name' => 'Nikhil Kumar',
                'email' => 'nicknikhilyadavnick@gmail.com',
                'contact'=>'6386565744',
                'notes'=> array('notes_key_1'=> 'Tea, Earl Grey, Hot','notes_key_2'=> 'Tea, Earl Grey… decaf')
            )
        );
        return $customer['id'];
    }
}
