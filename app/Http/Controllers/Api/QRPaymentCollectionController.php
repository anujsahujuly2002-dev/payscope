<?php

namespace App\Http\Controllers\Api;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Razorpay\Api\Api;
use App\Models\ApiPartner;
use App\Models\RazorPayLog;
use Illuminate\Http\Request;
use App\Models\UserWiseService;
use App\Models\QRPaymentCollection;
use App\Models\RazorapEventHistory;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Razorpay\Api\Errors\BadRequestError;
use App\Jobs\PaymentCollectionCallbackJob;
use App\Http\Requests\Api\FetchQrStatusRequest;
use App\Http\Requests\Api\QRPaymentCollectionRequest;

class QRPaymentCollectionController extends Controller
{
    protected $api;
    public function __construct()
    {
        $this->api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    }

    public function createQrCode(QRPaymentCollectionRequest $request) {
        $userId = $request->attributes->get('user_id');
        $checkServiceActive = UserWiseService::where('user_id',$userId)->first();
        if(is_null($checkServiceActive) ||$checkServiceActive->payin =='0'):
            return [
                'status'=>'0008',
                'msg'=>"This service has been down, Please try again after sometimes",
            ];
        endif;
        $checkRazorPayCustomerId = ApiPartner::where('user_id',$userId)->first();
        if($checkRazorPayCustomerId->razorpay_customer_id !=NULL):
            $customerId = $checkRazorPayCustomerId->razorpay_customer_id;
        else:
            $customerId  = $this->createCustomerId($checkRazorPayCustomerId->user->name,$checkRazorPayCustomerId->user->email,$checkRazorPayCustomerId->user->mobile_no,$checkRazorPayCustomerId->user_id);
        endif;
        $qrResponse = $this->generateQrCode($request->input('name'),$request->input('payment_amount'),$customerId,$checkRazorPayCustomerId->user_id,$request->input('order_id'));
        // dd($qrResponse);
        $qrImage=$qrResponse['image_url'];
        $imageData = base64_encode(file_get_contents($qrImage));
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
        $imageUrl = url('storage/qr_images/').'/'.$imageName;

        $qrResponse['qr_image_url'] =$imageUrl;
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
        $data=[
            'id'=>$response['id'],
            'entity'=>$response['entity'],
            'name'=>$response['name'],
            'email'=>$response['email'],
            'contact'=>$response['contact'],
            'gstin'=>$response['gstin'],
            'created_at'=>$response['created_at'],
        ];
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

    private function generateQrCode($name,$amount,$customerId,$userId,$orderId=NULL) {
        try {
            // Create QR code using Razorpay API
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
            $request =  [
                'type' => 'upi_qr',
                'name' => $name,
                'fixed_amount' => 1,
                'payment_amount' => $amount*100,
                "usage"=> "single_use",
                "customer_id"=>$customerId,
                "close_by"=> strtotime($currentTime->addMinutes(6)),
                'description' => 'QR code for payment'
            ];
            // dd(date('Y-m-d h:i:s',strtotime($time)),$request);
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
                'order_id'=>$orderId,
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
                'payment_type'=>'qr'
            ]);
            $data['order_id'] = $orderId;
            return $data;
        } catch (BadRequestError $e) {
            Log::info($e);
        } catch (\Exception $e) {
            // Handle all other errors
            Log::info($e);
        }
    }

    public function fetchQrStatus(FetchQrStatusRequest $request) {
        $userId = $request->attributes->get('user_id');
        $data = [];
        $qRPaymentCollection = QRPaymentCollection::where(['user_id'=>$userId])->where('qr_code_id',$request->input('qr_code_id'))->orWhere('payment_id',$request->input('qr_code_id'))->orWhere('order_id',$request->input('qr_code_id'))->first();
        if(!is_null($qRPaymentCollection)):
            $data =[
                'qr_code_id'=>$qRPaymentCollection['qr_code_id'],
                'order_id'=>$qRPaymentCollection['order_id'],
                'entity'=>$qRPaymentCollection['entity'],
                'name'=>$qRPaymentCollection['name'],
                'usage'=>$qRPaymentCollection['usage'],
                'type'=>$qRPaymentCollection['type'],
                'image_url'=>$qRPaymentCollection['image_url'],
                'payment_amount'=>$qRPaymentCollection['payment_amount'],
                'qr_status'=>$qRPaymentCollection['qr_status'],
                'description'=>$qRPaymentCollection['description'],
                'fixed_amount'=>$qRPaymentCollection['fixed_amount']?'1':'0',
                'payments_amount_received'=>$qRPaymentCollection['payments_amount_received'],
                'payments_count_received'=>$qRPaymentCollection['payments_count_received'],
                'qr_close_at'=>Carbon::parse($qRPaymentCollection['close_by'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
                'qr_created_at'=>Carbon::parse($qRPaymentCollection['created_at'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
                "status" => ucfirst(strip_tags($qRPaymentCollection->status->name)),
                "rrn_no" => ucfirst(strip_tags($qRPaymentCollection->utr_number)),
                "payer_upi_id" => ucfirst(strip_tags($qRPaymentCollection->payer_name)),
                "payment_id" => ucfirst(strip_tags($qRPaymentCollection->payment_id)),
            ];
        endif;

        return response()->json([
            'status'=>true,
            'data'=>$data
        ]);

    }

    public function webhookRecivedPaymentInRazorapy(Request $request){
        try{
            $paymentResponse = $request->all();
            RazorapEventHistory::create([
                'event'=>$paymentResponse['event'],
                'response'=>json_encode($request->all()),
            ]);
            if($paymentResponse['event']==='qr_code.credited'):
                QRPaymentCollection::where('qr_code_id',$paymentResponse['payload']['qr_code']['entity']['id'])->update([
                    'qr_status'=>$paymentResponse['payload']['qr_code']['entity']['status'],
                    'payments_amount_received'=>$paymentResponse['payload']['qr_code']['entity']['payments_amount_received']/100,
                    'payments_count_received'=>$paymentResponse['payload']['qr_code']['entity']['payments_count_received'],
                    'status_id'=>$paymentResponse['payload']['qr_code']['entity']['payments_amount_received'] !=0?'2':"3",
                    'close_by'=>Carbon::parse($paymentResponse['payload']['qr_code']['entity']['close_by'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
                    'close_reason'=>$paymentResponse['payload']['qr_code']['entity']['close_reason'],
                    'utr_number'=>$paymentResponse['payload']['payment']['entity']['acquirer_data']['rrn'],
                    'payment_id'=>$paymentResponse['payload']['payment']['entity']['id'],
                    'payer_name'=>$paymentResponse['payload']['payment']['entity']['vpa'],
                ]);
                $paymentCollection=QRPaymentCollection::where('qr_code_id',$paymentResponse['payload']['payment']['entity']['order_id'])->with('status')->first()->toArray();
                PaymentCollectionCallbackJob::dispatch($paymentCollection)->onQueue('qr-code-credit');
            endif;
        }catch (Exception $e){
            Log::info($request->all(),$e);
        }
    }

    public function upiIntent(QRPaymentCollectionRequest $request) {
        try {
            $userId = $request->attributes->get('user_id');
            $checkServiceActive = UserWiseService::where('user_id',$userId)->first();
            if(is_null($checkServiceActive) ||$checkServiceActive->payin =='0'):
                return [
                    'status'=>'0008',
                    'msg'=>"This service has been down, Please try again after sometimes",
                ];
            endif;
            $checkRazorPayCustomerId = ApiPartner::where('user_id',$userId)->first();
            if($checkRazorPayCustomerId->razorpay_customer_id !=NULL):
                $customerId = $checkRazorPayCustomerId->razorpay_customer_id;
            else:
                $customerId  = $this->createCustomerId($checkRazorPayCustomerId->user->name,$checkRazorPayCustomerId->user->email,$checkRazorPayCustomerId->user->mobile_no,$checkRazorPayCustomerId->user_id);
            endif;
            $order = $this->createPaymentOrder($request->input('payment_amount'));
            $requestParameter = [
                "amount" => $order['amount'],
                "currency" => "INR",
                "order_id" => $order['id'],
                "email" => $checkRazorPayCustomerId->user->email,
                "contact" => $checkRazorPayCustomerId->user->mobile_no,
                "method" => "upi",
                "customer_id" => "cust_P9lEOdEtSHA1FT",
                "ip" => $request->ip(),
                "referer" => "http",
                "user_agent" => "Mozilla/5.0",
                "description" => "Gorocery And Ecommerce Payment",
                // "notes" => array("note_key" => "value1"),
                "upi" => array(
                    "flow" => "intent"
                )
            ];
            $response = Http::withBasicAuth(env('RAZORPAY_KEY'),env('RAZORPAY_SECRET'))->post('https://api.razorpay.com/v1/payments/create/upi',$requestParameter);
            RazorPayLog::create([
                'user_id'=>$userId,
                'type'=>"upi_intent",
                'request'=>json_encode($requestParameter),
                'response'=>json_encode($response->json()),
            ]);
            QRPaymentCollection::create([
                'user_id'=>$userId,
                'qr_code_id'=>$order['id'],
                'order_id'=>$request->input('order_id'),
                'entity'=>'Intent',
                'name'=>$request->input('name'),
                'usage'=>"Single Use",
                'type'=>"UPI Intent",
                'image_url'=>$response->json()['link'],
                'payment_amount'=> $order['amount']/100,
                'qr_status'=>'Open',
                'description'=>"intent code for payment",
                'fixed_amount'=>'0',
                'payment_id'=>$response->json()['razorpay_payment_id'],
                'payments_amount_received'=>0,
                'payments_count_received'=>0,
                'qr_close_at'=>Carbon::parse(now())->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
                'qr_created_at'=>Carbon::parse(now())->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
                'status_id'=>"1",
                'payment_type'=>'intent',
            ]);
            $data['order_id'] = $request->input('order_id');
            if ($response) {
                $response = $response->json();
                $response['order_id'] =$request->input('order_id');
                $response['status'] = "Processd";
                return $response; // or dd($response->json());
            }

        }catch (Exception $e){
            return response()->json([
                'error' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function createPaymentOrder($amount=10)
    {
        return $this->api->order->create(array(
            'amount' => $amount*100,
            'method' => 'upi',
            'currency' => 'INR',
        ));

    }


    public function webHookOrderPaidCallBack(Request $request){
        try{
            $paymentResponse = $request->all();
            Log::info(json_encode($request->all()));
            $checkPendingOrder=QRPaymentCollection::where('qr_code_id',$paymentResponse['payload']['payment']['entity']['order_id'])->where('status_id','1')->first();
            if(!is_null($checkPendingOrder)):

                RazorapEventHistory::create([
                    'event'=>$paymentResponse['event'],
                    'response'=>json_encode($request->all()),
                ]);
                if($paymentResponse['event']==='order.paid'):
                    QRPaymentCollection::where('qr_code_id',$paymentResponse['payload']['payment']['entity']['order_id'])->update([
                        'qr_status'=>$paymentResponse['payload']['payment']['entity']['status'],
                        'payments_amount_received'=>$paymentResponse['payload']['payment']['entity']['amount']/100,
                        'status_id'=>$paymentResponse['payload']['payment']['entity']['status'] =='captured'?'2':"3",
                        'close_by'=>Carbon::parse($paymentResponse['payload']['payment']['entity']['captured_at'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
                        'close_reason'=>$paymentResponse['payload']['order']['entity']['status'],
                        'utr_number'=>$paymentResponse['payload']['payment']['entity']['acquirer_data']['rrn'],
                        'payment_id'=>$paymentResponse['payload']['payment']['entity']['id'],
                        'payer_name'=>$paymentResponse['payload']['payment']['entity']['upi']['vpa'],
                    ]);
                    $paymentCollection=QRPaymentCollection::where('qr_code_id',$paymentResponse['payload']['payment']['entity']['order_id'])->with('status')->first()->toArray();
                    PaymentCollectionCallbackJob::dispatch($paymentCollection)->onQueue('payment-collection-success');
                endif;
            endif;

        }catch (Exception $e){
            Log::info([json_encode($request->all()),$e]);
        }
    }

}
