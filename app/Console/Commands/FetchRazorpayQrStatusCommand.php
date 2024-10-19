<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Razorpay\Api\Api;
use Illuminate\Console\Command;
use App\Models\QRPaymentCollection;

class FetchRazorpayQrStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-razorpay-qr-status-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieves the status of a Razorpay QR code transaction, checking if payments are completed, pending, or failed for efficient transaction management';
    protected $api;
    /**
     * Execute the console command.
     */

    public function handle()
    {
        $this->api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $getAllActiveQrs = QRPaymentCollection::where('qr_status','active')->get();
        foreach($getAllActiveQrs as $getAllActiveQr):
            if($this->fetchQrStatus($getAllActiveQr->qr_code_id)['status'] =='closed'):
                $getAllActiveQr->update([
                    'qr_status'=>$this->fetchQrStatus($getAllActiveQr->qr_code_id)['status'],
                    'payments_amount_received'=>$this->fetchQrStatus($getAllActiveQr->qr_code_id)['payments_amount_received']/100,
                    'payments_count_received'=>$this->fetchQrStatus($getAllActiveQr->qr_code_id)['payments_count_received'],
                    'status_id'=>$this->fetchQrStatus($getAllActiveQr->qr_code_id)['payments_amount_received'] !=0?'2':"3",
                    'close_by'=>Carbon::parse($this->fetchQrStatus($getAllActiveQr->qr_code_id)['close_by'])->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s'),
                    'close_reason'=>$this->fetchQrStatus($getAllActiveQr->qr_code_id)['close_reason'],
                ]);
            endif;
        endforeach;
        
    }

    private function fetchQrStatus($qrCodeId) {
        return $this->api->qrCode->fetch($qrCodeId);
    }


    
}
