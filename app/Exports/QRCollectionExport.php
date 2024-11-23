<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\QRPaymentCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class QRCollectionExport implements FromCollection,WithHeadings
{

    public $data;

    public function __construct($data){
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $qrPaymentCollections = QRPaymentCollection::when($this->data['start_date'] && $this->data['end_date'], function($query) {
            $query->whereDate('created_at', '>=', $this->data['start_date'])
                  ->whereDate('created_at', '<=',$this->data['end_date']);
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
        })->with('user');
        foreach($qrPaymentCollections->get() as $qrPaymentCollection):
            $qrCollectionArray[]=[
                $qrPaymentCollection->user->name,
                $qrPaymentCollection->qr_code_id,
                $qrPaymentCollection->payment_amount,
                $qrPaymentCollection->payments_amount_received,
                $qrPaymentCollection->qr_status,
                $qrPaymentCollection->close_reason,
                strip_tags($qrPaymentCollection->status?->name),
                Carbon::parse($qrPaymentCollection->created_at)->format('dS M Y H:i:s'),
            ];
        endforeach;

        return collect($qrCollectionArray);
    }


    public function headings(): array
    {
        return ['Name',
            'QR ID',
            'Amount',
            'Received Amount',
            'Current Status',
            'QR Close Reason',
            'Status',
            'Date'];
    }
}

