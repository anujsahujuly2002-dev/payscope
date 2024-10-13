<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use Razorpay\Api\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    protected $api;

    public function __construct()
    {
        $this->api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    }

    public function index(){
        // Define amount
        $amount = 10;
        //   $order = $this->createOrder($amount);
        $time = Carbon::now('Asia/Kolkata')->addMinutes(4)->format('Y-m-d h:i:s');
        // dd($time);
        $request = [
            // "type" => "upi_qr",
            // "name" => "Vikash Kuamr", 
            // "usage" => "single_use",
            // "fixed_amount" => 1,
            // "payment_amount" => 10*100,
            // "customer_id" => 'cust_P8Q0gFEGB2JBfE',
            // "description" => "Payment",
            // "close_by" => strtotime($time),
            // "notes" => array("purpose" => "Test UPI QR code notes")
            "type"=> "upi_qr",
            "name"=> "Store Front Display",
            "usage"=> "single_use",
            "fixed_amount"=> true,
            "payment_amount"=> 300,
            "description"=> "For Store 1",
            "customer_id"=>"cust_P8Q0gFEGB2JBfE",
            "close_by"=> strtotime($time),
            "notes"=> [
                "purpose"=> "Test UPI QR Code notes"
            ]
        ];
        // dd($request);
        //   $paymentLink = $this->api->QrCode->create($request);
        try {
            $paymentLink=$this->api->qrCode->create($request);
            $qrID=$paymentLink['id'];
            $qrImage=$paymentLink['image_url'];
            $imageData = base64_encode(file_get_contents($qrImage));
            $src = 'data: ;base64,' . $imageData;
            $image= "<img src='".$src."' width='300'>";
        } catch (Exception $th) {
            dd($th);
        }   
            
        // Use a QR code package like Simple QR Code in Laravel to display the QR code
        return view('welcome', ['qrCodeUrl' => $image]);
        
        // return view('welcome', ['order' => $order,'qr_code_url' => $qrCode['short_url']]);
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
