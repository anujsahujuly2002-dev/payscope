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
        try{
            $intent =$this->api->payment->createUpi(
                array(
                    "amount" => $order['amount']/100,
                    "currency" => "INR",
                    "order_id" => $order['id'],
                    "email" => "nicknikhilyadavnick@gmail.com",
                    "contact" => "6386565744",
                    // "method" => "upi",
                    "customer_id" => "cust_P9lEOdEtSHA1FT",
                    "ip" => "192.168.0.103",
                    "referer" => "https://login.groscope.com",
                    "user_agent" => "Mozilla/5.0",
                    "description" => "Test flow",
                    "notes" => array("note_key" => "value1"),
                    "upi" => array("flow" => "intent")
                )
            );
        }catch(Exception $e) {
            dd($e);
        }
        dd($intent);
    }

    public function createOrder($amount, $currency = 'INR')
    {
        $order = $this->api->order->create([
            'amount' => $amount * 100,  // Amount in paise (₹100 = 10000 paise)
            'currency' => 'INR',
            'payment_capture' => 1,
            'method' => 'upi'
        ]);
        return $order;
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
