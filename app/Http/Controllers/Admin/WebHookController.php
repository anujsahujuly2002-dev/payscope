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
        try {
            // Validate Authorization Header
            $headers = $request->header();
            if (!isset($headers['authorization'][0])) {
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
            return response()->json([
                'status' => false,
                'message' => "Database error occurred. Please try again."
            ], 500);

        } catch (Exception $e) {
            // General exceptions
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
