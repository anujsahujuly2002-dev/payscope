<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\FundRequest;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
// use Maatwebsite\Excel\Concerns\ShouldQueue; // ✅ Import this interface
use Illuminate\Contracts\Queue\ShouldQueue as LaravelShouldQueue; // ✅ Required for proper queuing

class PayoutRequestExport implements FromQuery,WithHeadings,LaravelShouldQueue,WithMapping
{
    public $data;

    public function __construct($data){
        ini_set('memory_limit', '-1');
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */

     /**
     * Query for large datasets
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return FundRequest::query()
            ->when($this->data['start_date'] && $this->data['end_date'], function($query) {
                $query->whereDate('created_at', '>=', $this->data['start_date'])
                      ->whereDate('created_at', '<=', $this->data['end_date']);
            })
            ->when($this->data['user_id'], function($query) {
                $query->where('user_id', $this->data['user_id']);
            })
            ->when($this->data['start_date'] && !$this->data['end_date'], function($query) {
                $query->whereDate('created_at', '>=', $this->data['start_date']);
            })
            ->when($this->data['value'], function($query) {
                $query->where('qr_code_id', $this->data['value']);
            })
            ->when($this->data['status'] !== null, function($query) {
                $query->where('status_id', $this->data['status']);
            })
            ->with('user','status');
    }
    

    /**
     * Map each row of data to the desired format
     *
     * @param $fundRequest
     * @return array
     */
    public function map($fundRequest): array
    {
        return [
            $fundRequest->user->name,
            $fundRequest->payout_id,
            $fundRequest->payout_ref,
            // $fundRequest->payoutTransactionHistories?->balance??"0",
            $fundRequest->payoutTransactionHistories?->amount??"0",
            $fundRequest->payoutTransactionHistories?->charge??"0",
            $fundRequest->payoutTransactionHistories?->gst??"0",
            $fundRequest->payoutTransactionHistories->amount+ $fundRequest->payoutTransactionHistories->charge+$fundRequest->payoutTransactionHistories->gst,
            // $fundRequest->payoutTransactionHistories?->closing_balnce??"0",
            strip_tags($fundRequest->status?->name),
            Carbon::parse( $fundRequest->payoutTransactionHistories?->created_at)->format('dS M Y'),
        ];
    }

     /**
     * Define the CSV headers
     *
     * @return array
     */
    public function headings(): array
    {
        return ["Name", "Payout Id", "Payment Reference Number",'Order Amount','Charges' ,'GST','Total Amount','Status','Date'];
    }
}
