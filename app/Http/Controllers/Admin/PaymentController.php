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
        // dd($_SERVER);
        // dd($this->api->payment->fetchPaymentMethods());
        $order = $this->createOrder(10);
        // dd($order);
        try{
            $request = [
                "amount" => $order['amount']/100,
                    "currency" => "INR",
                    "order_id" => $order['id'],
                    "email" => "nicknikhilyadavnieck@gmail.com",
                    "contact" => "6386565743",
                    "method" => "upi",
                    "customer_id" => "cust_P9lEOdEtSHA1FT",
                    // "ip" => "106.219.152.38",
                    // "referer" => "https://login.groscope.com",
                    // "user_agent" => $_SERVER['HTTP_USER_AGENT'],
                    "description" => "Payment For Groscery",
                    // "notes" => array("note_key" => "value1"),
                    "upi" => array("flow" => "intent")
            ];
            // dd($request);
            $intent =$this->api->payment->createUpi($request);
            dd($intent);
        }catch(Exception $e) {
            dd($e);
        }
        dd($intent);
    }

    public function createOrder($amount, $currency = 'INR')
    {
        /* $order = $this->api->order->create([
            'amount' => $amount * 100,  // Amount in paise (₹100 = 10000 paise)
            'currency' => 'INR',
            'payment_capture' => 1,
            'method' => 'upi'
        ]); */
        return $this->api->order->create(array('amount' => 1000,'currency' => 'INR','receipt' => 'rcptid_11','payment' => array('capture' => 'automatic','capture_options' => array('automatic_expiry_period' => 12,'manual_expiry_period' => 7200,'refund_speed' => 'optimum'))));

        
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
