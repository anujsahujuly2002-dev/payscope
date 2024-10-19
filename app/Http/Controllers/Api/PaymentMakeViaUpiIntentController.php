<?php

namespace App\Http\Controllers\Api;

use Razorpay\Api\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentMakeViaUpiIntentController extends Controller
{
    protected $api;
    public function __construct()
    {
        $this->api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    }
    public function paymentInViaUpiIntent(Request $request) {
        $userId = $request->attributes->get('user_id');
        // Data for the order, amount in paise (e.g. 100 INR = 10000 paise)
        $orderData = [
            'receipt'         => 'order_rcptid_11',
            'amount'          => 50000, // Amount in paise (500 INR)
            'currency'        => 'INR',
            'payment_capture' => 1, // Auto-capture
        ];
        $order = $this->api->order->create($orderData);

    }
    public function generateUpiIntentUrl($orderId, $amount, $vpa){
        // UPI Intent URL format for Razorpay
        $upiUrl = "upi://pay?pa={$vpa}&pn=Nikhil Kumar&mc=0000&tid={$orderId}&tr={$orderId}&tn=Payment%20for%20Order&am=" . ($amount / 100) . "&cu=INR";

        return $upiUrl;
    }
}
