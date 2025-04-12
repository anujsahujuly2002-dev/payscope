<?php

namespace App\Jobs;

use Exception;
use Carbon\Carbon;
use App\Models\Status;
use App\Models\ApiToken;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\AutoPayinTransactionUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PaymentCollectionCallbackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $transaction;
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $webhookUrl = ApiToken::where('user_id',  $this->transaction['user_id'])->latest()->first();
        if (!is_null($webhookUrl) && $webhookUrl->payin_webhook_url !== NULL) {
            $parameters = [
                "status" => true,
                "msg" => "You're request has been complete",
                "data" => [
                    'qr_code_id'=>$this->transaction['qr_code_id'],
                    'order_id'=>$this->transaction['merchant_order_id'],
                    'entity'=>$this->transaction['entity'],
                    'name'=>$this->transaction['name'],
                    'usage'=>$this->transaction['usage'],
                    'type'=>$this->transaction['type'],
                    'image_url'=>$this->transaction['image_url'],
                    'payment_amount'=>$this->transaction['payment_amount'],
                    // 'qr_status'=>$this->transaction['qr_status'],
                    'description'=>$this->transaction['description'],
                    'fixed_amount'=>$this->transaction['fixed_amount']?'1':'0',
                    'payments_amount_received'=>$this->transaction['payments_amount_received'],
                    'payments_count_received'=>$this->transaction['payments_count_received'],
                    'qr_close_at'=>Carbon::parse($this->transaction['close_by'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
                    'qr_created_at'=>Carbon::parse($this->transaction['created_at'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
                    "rrn_no" => ucfirst(strip_tags($this->transaction['utr_number'])),
                    "payer_upi_id" => ucfirst(strip_tags($this->transaction['payer_name'])),
                    "payment_id" => ucfirst(strip_tags($this->transaction['payment_id'])),
                    "status" => ucfirst(strip_tags($this->getStatus($this->transaction['status_id']))),
                ],
            ];
            try{
                // Log::info(['parameters'=>json_encode($parameters)]);
                Http::retry(3, 100)->post($webhookUrl->payin_webhook_url ,$parameters);
                AutoPayinTransactionUpdate::create([
                    'user_id'=> $this->transaction['user_id'],
                    'qr_collection_id'=> $this->transaction['id'],
                    'webhook_url'=>$webhookUrl->domain
                ]);
            }catch(Exception $e) {
                Log::error($e->getMessage());
            }

        } else {
            Log::info("Webhook Url Not a registerd");
        }
    }

    private function getStatus($id) {
        return Status::find($id)->name;
    }
}
