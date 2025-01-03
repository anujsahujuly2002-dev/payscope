<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\QRPaymentCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
// use Maatwebsite\Excel\Concerns\ShouldQueue; // ✅ Import this interface
use Illuminate\Contracts\Queue\ShouldQueue as LaravelShouldQueue; // ✅ Required for proper queuing

class QRCollectionExport implements FromQuery, WithHeadings, WithMapping, LaravelShouldQueue
{
    public $data;

    public function __construct($data)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 1000000);
        $this->data = $data;
    }

    /**
     * Query for large datasets
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return QRPaymentCollection::query()
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
     * @param $qrPaymentCollection
     * @return array
     */
    public function map($qrPaymentCollection): array
    {
        return [
            $qrPaymentCollection->user?->name ?? 'N/A', 
            $qrPaymentCollection->user?->email ?? 'N/A', 
            $qrPaymentCollection->qr_code_id,
            $qrPaymentCollection->payment_id,
            $qrPaymentCollection->payment_amount,
            $qrPaymentCollection->payments_amount_received,
            $qrPaymentCollection->qr_status,
            $qrPaymentCollection->close_reason,
            strip_tags($qrPaymentCollection->status?->name),
            Carbon::parse($qrPaymentCollection->created_at)->format('dS M Y H:i:s'),
        ];
    }

    /**
     * Define the CSV headers
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'QR ID',
            'Payment Id',
            'Amount',
            'Received Amount',
            'Current Status',
            'QR Close Reason',
            'Status',
            'Date'
        ];
    }
}
