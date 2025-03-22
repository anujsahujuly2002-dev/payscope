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
        // Define amount
        $amount = 10;
        //   $order = $this->createOrder($amount);
         // Set the current time in the 'Asia/Kolkata' timezone
         $currentTime = Carbon::now('Asia/Kolkata');

         // Set 'close_by' time to be 4 minutes after the current time
         $closeByTime = $currentTime->copy()->addMinutes(4);

         // Check if 'close_by' is at least 2 minutes after the current time
         if ($closeByTime->greaterThan($currentTime->addMinutes(2))) {
             // echo "close_by is at least 2 minutes after the current time.";
         } else {
             // echo "close_by is less than 2 minutes after the current time.";
         }
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
            "customer_id"=>"cust_P9lEOdEtSHA1FT",
            "close_by"=> strtotime($currentTime->addMinutes(6)),
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
            // Read the image contents
            $imageContent = file_get_contents($qrImage);

            // Base64 encode without padding ('=')
            // Save the QR image to a public path
            // mkdir(storage_path().'/qr_images');
            $imageDirectory = storage_path('app/public/qr_images');

            // Check if the directory exists, if not, create it
            if (!is_dir($imageDirectory)) {
                mkdir($imageDirectory, 0755, true); // 0755 is the permission, true enables recursive creation
            }
            
            // Now set the image path
            $imagePath = $imageDirectory;
            $imageName = 'qr_image_'.time().'.png';
            // Store the image on the server
            file_put_contents($imagePath.'/'.$imageName, file_get_contents($qrImage));

            // Instead of encoding the image, store the URL or path
            $imageUrl = url('public/storage/qr_images/').'/'.$imageName;
            dd($imageUrl );
            // $imageData = base64_encode(file_get_contents($qrImage));
            // $src = 'data: ;base64,' . $imaimageUrlgeData;
            $image= "<img src='".$imageUrl."' width='300'>";
            // dd($image);
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
