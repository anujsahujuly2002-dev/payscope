<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Razorpay\Api\Api;
use App\Models\ApiPartner;
use App\Models\RazorPayLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FetchQrStatusRequest;
use Razorpay\Api\Errors\BadRequestError;
use App\Http\Requests\Api\QRPaymentCollectionRequest;
use App\Models\QRPaymentCollection;

class QRPaymentCollectionController extends Controller
{
    protected $api;
    public function __construct()
    {
        $this->api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    }
    public function createQrCode(QRPaymentCollectionRequest $request) {
        $userId = $request->attributes->get('user_id');
        $checkRazorPayCustomerId = ApiPartner::where('user_id',$userId)->first();
        if($checkRazorPayCustomerId->razorpay_customer_id !=NULL):
            $customerId = $checkRazorPayCustomerId->razorpay_customer_id;
        else:
            $customerId  = $this->createCustomerId($checkRazorPayCustomerId->parentDetails->name,$checkRazorPayCustomerId->parentDetails->email,$checkRazorPayCustomerId->parentDetails->mobile_no,$checkRazorPayCustomerId->id);
        endif;
        $qrResponse = $this->generateQrCode($request->input('name'),$request->input('payment_amount'),$customerId,$checkRazorPayCustomerId->user_id);
        $qrImage=$qrResponse['image_url'];
        $imageData = base64_encode(file_get_contents($qrImage));
        $src = 'data: ;base64,' . $imageData;
        $qrResponse['qr_image_url'] =$src;
        $qrResponse['payment_amount'] =$qrResponse['payment_amount']/100;
        return response()->json([
            'status'=>true,
            'data'=>$qrResponse
        ]);
    }

    private function createCustomerId($name,$email,$mobile_no,$userId) {
        $response=$this->api->customer->create([
            'name'=>$name,
            'email'=>$email,
            'contact'=>$mobile_no,
        ]);
        RazorPayLog::create([
            'user_id'=>$userId,
            'type'=>"customer_create",
            'request'=>json_encode([
                'name'=>$name,
                'email'=>$email,
                'contact'=>$mobile_no,
            ]),
            'response'=>json_encode($response),
        ]);
        ApiPartner::where('user_id',$userId)->update([
            'razorpay_customer_id'=>$response['id']
        ]);
        return $response['id'];
    }

    private function generateQrCode($name,$amount,$customerId,$userId) {
        try {
            // Create QR code using Razorpay API
            $time = Carbon::now('Asia/Kolkata')->addMinutes(4)->format('Y-m-d h:i:s');
            $request =  [
                'type' => 'upi_qr',
                'name' => $name,
                'fixed_amount' => 1,
                'payment_amount' => $amount*100,
                "usage"=> "single_use",
                "customer_id"=>$customerId,
                "close_by"=> strtotime($time),
                'description' => 'QR code for payment'
            ];
            $response = $this->api->qrCode->create($request);
            // dd($response);
            $data =[
                "id"=> $response['id'],
                "entity"=> $response['entity'],
                "created_at"=> $response['created_at'],
                "name"=> $response['name'],
                "usage"=> $response['usage'],
                "type"=> $response['type'],
                "image_url"=> $response['image_url'],
                "payment_amount"=>$response['payment_amount'],
                "status"=> $response['status'],
                "description"=> $response['description'],
                "fixed_amount"=> $response['fixed_amount'],
                "payments_amount_received"=> $response['payments_amount_received'],
                "payments_count_received"=> $response['payments_count_received'],
                "close_by"=> $response['close_by'],
            ];
            RazorPayLog::create([
                'user_id'=>$userId,
                'type'=>"qr_genrate",
                'request'=>json_encode($request),
                'response'=>json_encode($data)
            ]);
            QRPaymentCollection::create([
                'user_id'=>$userId,
                'qr_code_id'=>$data['id'],
                'entity'=>$data['entity'],
                'name'=>$data['name'],
                'usage'=>$data['usage'],
                'type'=>$data['type'],
                'image_url'=>$data['image_url'],
                'payment_amount'=>$data['payment_amount']/100,
                'qr_status'=>$data['status'],
                'description'=>$data['description'],
                'fixed_amount'=>$data['fixed_amount']?'1':'0',
                'payments_amount_received'=>$data['payments_amount_received'],
                'payments_count_received'=>$data['payments_count_received'],
                'qr_close_at'=>Carbon::parse($data['close_by'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
                'qr_created_at'=>Carbon::parse($data['created_at'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
                'status_id'=>"1",
            ]);
            return $data;
        } catch (BadRequestError $e) {
            // Handle Bad Request error (most common for missing/invalid parameters)
            echo "BadRequestError: " . $e->getMessage();
        } catch (\Exception $e) {
            // Handle all other errors
            echo "Error: " . $e->getMessage();
        }
    }

    public function fetchQrStatus(FetchQrStatusRequest $request) {
        $userId = $request->attributes->get('user_id');
        $qRPaymentCollection = QRPaymentCollection::where(['user_id'=>$userId,'qr_code_id'=>$request->input('qr_code_id')])->first();
        // dd($qRPaymentCollection->status->name);
        $data =[
            'qr_code_id'=>$qRPaymentCollection['id'],
            'entity'=>$qRPaymentCollection['entity'],
            'name'=>$qRPaymentCollection['name'],
            'usage'=>$qRPaymentCollection['usage'],
            'type'=>$qRPaymentCollection['type'],
            'image_url'=>$qRPaymentCollection['image_url'],
            'payment_amount'=>$qRPaymentCollection['payment_amount']/100,
            'qr_status'=>$qRPaymentCollection['qr_status'],
            'description'=>$qRPaymentCollection['description'],
            'fixed_amount'=>$qRPaymentCollection['fixed_amount']?'1':'0',
            'payments_amount_received'=>$qRPaymentCollection['payments_amount_received'],
            'payments_count_received'=>$qRPaymentCollection['payments_count_received'],
            'qr_close_at'=>Carbon::parse($qRPaymentCollection['close_by'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
            'qr_created_at'=>Carbon::parse($qRPaymentCollection['created_at'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
            "status" => ucfirst(strip_tags($qRPaymentCollection->status->name)),
        ];

        return response()->json([
            'status'=>true,
            'date'=>$data
        ]);

    }


}
