<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\QRPaymentCollection;
use App\Jobs\PaymentCollectionCallbackJob;
use App\Models\RazorapEventHistory;
use Exception;

class WebHookController extends Controller
{
    public function phonePeCallBack(Request $request) {
        // try{ 
        //     Log::info([json_encode($request->all())]);
        //     $authorizationHash = $request->header()['authorization']['0'];
        //     if(!$this->checkHeaderAuthorization($authorizationHash ))
        //     return response()->json([
        //         'status'=>false,
        //         "messgae"=>"Authorization token does not match."
        //     ]);
        //     $paymentResponse = $request->all();
        //     if($paymentResponse['event']==='checkout.order.completed'):
        //         RazorapEventHistory::create([
        //             'event'=>$paymentResponse['event'],
        //             'payment_channel'=>'phone-pe',
        //             'response'=>json_encode($request->all()),
        //         ]); 
        //         QRPaymentCollection::where('qr_code_id',$paymentResponse['payload']['orderId'])->update([
        //             'payments_amount_received'=>$paymentResponse['payload']['amount']/100,
        //             'status_id'=>$paymentResponse['payload']['state'] =='COMPLETED'?'2':"3",
        //             // 'close_by'=>Carbon::parse($paymentResponse['payload']['expireAt'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
        //             'utr_number'=>$paymentResponse['payload']['paymentDetails'][0]['rail']['utr'],
        //             'payment_id'=>$paymentResponse['payload']['paymentDetails'][0]['rail']['upiTransactionId'],
        //             // 'payer_name'=>$paymentResponse['payload']['payment']['entity']['upi']['vpa'],
        //         ]);
        //         $paymentCollection=QRPaymentCollection::where('qr_code_id',$paymentResponse['payload']['orderId'])->with('status')->first()->toArray();
        //         PaymentCollectionCallbackJob::dispatch($paymentCollection)->onQueue('payment-collection-success');
        //     elseif($paymentResponse['event']==='checkout.order.failed'):
        //         RazorapEventHistory::create([
        //             'event'=>$paymentResponse['event'],
        //             'payment_channel'=>'phone-pe',
        //             'response'=>json_encode($request->all()),
        //         ]); 
        //         QRPaymentCollection::where('qr_code_id',$paymentResponse['payload']['orderId'])->update([
        //             'payments_amount_received'=>$paymentResponse['payload']['amount']/100,
        //             'status_id'=>$paymentResponse['payload']['state'] =='FAILED'?'3':"2",
        //             // 'close_by'=>Carbon::parse($paymentResponse['payload']['expireAt'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
        //             // 'utr_number'=>$paymentResponse['payload']['paymentDetails']['entity']['acquirer_data']['rrn'],
        //             // 'payment_id'=>$paymentResponse['payload']['payment']['entity']['id'],
        //             // 'payer_name'=>$paymentResponse['payload']['payment']['entity']['upi']['vpa'],
        //             'utr_number'=>$paymentResponse['payload']['paymentDetails'][0]['rail']['utr'],
        //             'payment_id'=>$paymentResponse['payload']['paymentDetails'][0]['rail']['upiTransactionId'],
        //         ]);
        //         $paymentCollection=QRPaymentCollection::where('qr_code_id',$paymentResponse['payload']['orderId'])->with('status')->first()->toArray();
        //         PaymentCollectionCallbackJob::dispatch($paymentCollection)->onQueue('payment-collection-success');
        //     endif;
        // }catch (Exception $e){
        //     return response()->json(['status'=>'false','message' => $e->getMessage()], 401);
        // }   
        try { 
            // Log incoming request data
            Log::info(['request_data' => json_encode($request->all())]);
    
            // Validate Authorization Header
            $headers = $request->header();
            if (!isset($headers['authorization'][0])) {
                Log::info("Missing authorization header.");
                throw new Exception("Missing authorization header.");
            }
    
            $authorizationHash = $headers['authorization'][0];
            if (!$this->checkHeaderAuthorization($authorizationHash)) {
                return response()->json([
                    'status' => false,
                    'message' => "Authorization token does not match."
                ], 403);
            }
    
            // Validate Event Payload
            $paymentResponse = $request->all();
            if (!isset($paymentResponse['event'], $paymentResponse['payload']['orderId'])) {
                throw new Exception("Invalid payload structure.");
            }
    
            // Process Payment Events
            if ($paymentResponse['event'] === 'checkout.order.completed') {
                RazorapEventHistory::create([
                    'event' => $paymentResponse['event'],
                    'payment_channel' => 'phone-pe',
                    'response' => json_encode($paymentResponse),
                ]); 
    
                QRPaymentCollection::where('qr_code_id', $paymentResponse['payload']['orderId'])
                    ->update([
                        'payments_amount_received' => $paymentResponse['payload']['amount'] / 100,
                        'status_id' => ($paymentResponse['payload']['state'] === 'COMPLETED') ? '2' : "3",
                        'utr_number' => $paymentResponse['payload']['paymentDetails'][0]['rail']['utr'] ?? null,
                        'payment_id' => $paymentResponse['payload']['paymentDetails'][0]['rail']['upiTransactionId'] ?? null,
                    ]);
    
                $paymentCollection = QRPaymentCollection::where('qr_code_id', $paymentResponse['payload']['orderId'])
                    ->with('status')->first();
    
                if ($paymentCollection) {
                    PaymentCollectionCallbackJob::dispatch($paymentCollection->toArray())->onQueue('payment-collection-success');
                }
    
            } elseif ($paymentResponse['event'] === 'checkout.order.failed') {
                RazorapEventHistory::create([
                    'event' => $paymentResponse['event'],
                    'payment_channel' => 'phone-pe',
                    'response' => json_encode($paymentResponse),
                ]);
    
                QRPaymentCollection::where('qr_code_id', $paymentResponse['payload']['orderId'])
                    ->update([
                        'payments_amount_received' => $paymentResponse['payload']['amount'] / 100,
                        'status_id' => ($paymentResponse['payload']['state'] === 'FAILED') ? '3' : "2",
                        'utr_number' => $paymentResponse['payload']['paymentDetails'][0]['rail']['utr'] ?? null,
                        'payment_id' => $paymentResponse['payload']['paymentDetails'][0]['rail']['upiTransactionId'] ?? null,
                    ]);
    
                $paymentCollection = QRPaymentCollection::where('qr_code_id', $paymentResponse['payload']['orderId']) ->with('status')->first();
    
                if ($paymentCollection) {
                    PaymentCollectionCallbackJob::dispatch($paymentCollection->toArray())->onQueue('payment-collection-success');
                }
            }
    
            return response()->json(['status' => true, 'message' => "Payment processed successfully."]);
    
        } catch (QueryException $qe) {
            // Database query-related exception
            Log::error("Database Error: " . $qe->getMessage());
            return response()->json([
                'status' => false,
                'message' => "Database error occurred. Please try again."
            ], 500);
    
        } catch (Exception $e) {
            // General exceptions
            Log::error("Payment Processing Error: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }

    }

    private function checkHeaderAuthorization($authorizationHash) {
        try {
            $expectedHash = hash('sha256', "MjrqxDE3:MjxDE3421");
            if ($expectedHash === $authorizationHash) {
                return true;
            }
    
            throw new Exception("Unauthorized access: Invalid authorization hash.");
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
       
    }
}
