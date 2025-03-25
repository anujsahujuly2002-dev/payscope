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
}
