<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\UserWiseService;
use App\Http\Helper\Payin\PhonePe;
use App\Models\QRPaymentCollection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PaymentCollectionRequest;
use Exception;
use App\Http\Requests\Api\FetchQrStatusRequest;

class PaymentCollectionController extends Controller
{
    protected $phonePe;
    public function __construct()
    {
        $this->phonePe = new PhonePe();
    }

    public function upiIntent(PaymentCollectionRequest $request) {
        try{
            $userId = $request->attributes->get('user_id');
            $checkServiceActive = UserWiseService::where('user_id',$userId)->first();
            if(is_null($checkServiceActive) ||$checkServiceActive->payin =='0'):
                return [
                    'status'=>'0008',
                    'msg'=>"This service has been down, Please try again after sometimes",
                ];
            endif;
            $requestParameter = $request->all();
            do {
                $requestParameter['order_id'] = 'GROSC'.rand(111111111111, 999999999999);
            } while (QRPaymentCollection::where("order_id", $requestParameter['order_id'])->first() instanceof QRPaymentCollection);
            $requestParameter['user_id'] =$request->attributes->get('user_id');;

            $requestParameter['user_id'] =$userId;
            $requestParameter['amount'] = $request->input('payment_amount');
            $response = $this->phonePe->initiatePayment($requestParameter);
            if($response['status']):
                QRPaymentCollection::create([
                    'user_id'=>$userId,
                    'qr_code_id'=>$response['data']['orderId'],
                    'order_id'=>$requestParameter['order_id'],
                    'merchant_order_id'=>$request->input('order_id')??$requestParameter['order_id'],
                    'name'=>$requestParameter['name'],
                    'email'=>$requestParameter['email'],
                    'mobile_no'=>$requestParameter['mobile_no'],
                    'type'=>'intent',
                    'payment_amount'=>$requestParameter['amount'],
                    'qr_status'=>"Pending",
                    'fixed_amount'=>'1',
                    'qr_close_at'=>Carbon::parse($response['data']['expireAt'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
                    'qr_created_at'=>now()->format('Y-m-d h:i:s'),
                    'status_id'=>"1",
                    'payment_type'=>'qr',
                    'payment_channel'=>'phone-pe',
                    'payments_count_received'=>'1',
                ]);
                $data = [
                    "status"=>true,
                    "message"=>"You're request has been complete",
                    "data"=>[
                        "order_id"=>$request->input('order_id'),
                        "url"=>$response['data']['redirectUrl']
                    ]
                ];
                return response()->json($data);
            else:
                return response()->json($response);
            endif;

        }catch(Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }

    }

    public function fetchQrStatus(FetchQrStatusRequest $request) {
        $userId = $request->attributes->get('user_id');
        $data = [];
        $qRPaymentCollection = QRPaymentCollection::where(['user_id'=>$userId])->where('qr_code_id',$request->input('qr_code_id'))->orWhere('payment_id',$request->input('qr_code_id'))->orWhere('order_id',$request->input('qr_code_id'))->orWhere('merchant_order_id',$request->input('qr_code_id'))->first();
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
                // 'qr_status'=>$qRPaymentCollection['qr_status'],
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

    
}
