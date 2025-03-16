<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\QRPaymentCollection;
use App\Jobs\PaymentCollectionCallbackJob;
use App\Models\RazorapEventHistory;

class WebHookController extends Controller
{
    public function phonePeCallBack(Request $request) {
        try{ 
            $authorizationHash = $request->header()['authorization']['0'];
            if(!$this->checkHeaderAuthorization($authorizationHash ))
            return Log::info('Authorization token does not match.');
            $paymentResponse = $request->all();
            if($paymentResponse['event']==='checkout.order.completed'):
                RazorapEventHistory::create([
                    'event'=>$paymentResponse['event'],
                    'payment_channel'=>'phone-pe',
                    'response'=>json_encode($request->all()),
                ]); 
                QRPaymentCollection::where('qr_code_id',$paymentResponse['payload']['orderId'])->update([
                    'payments_amount_received'=>$paymentResponse['payload']['amount']/100,
                    'status_id'=>$paymentResponse['payload']['state'] =='COMPLETED'?'2':"3",
                    // 'close_by'=>Carbon::parse($paymentResponse['payload']['expireAt'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
                    // 'utr_number'=>$paymentResponse['payload']['paymentDetails']['entity']['acquirer_data']['rrn'],
                    // 'payment_id'=>$paymentResponse['payload']['payment']['entity']['id'],
                    // 'payer_name'=>$paymentResponse['payload']['payment']['entity']['upi']['vpa'],
                ]);
                $paymentCollection=QRPaymentCollection::where('qr_code_id',$paymentResponse['payload']['orderId'])->with('status')->first()->toArray();
                PaymentCollectionCallbackJob::dispatch($paymentCollection)->onQueue('payment-collection-success');
            endif;
        }catch (Exception $e){
            Log::info([json_encode($request->all()),$e]);
        }        
    }



    private function checkHeaderAuthorization($authorizationHash) {
        return hash('sha256', "MjrqxDE3:MjxDE3421") === $authorizationHash;
    }
}
