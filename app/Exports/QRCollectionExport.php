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

        $request = QRPaymentCollection::with('user');
        $qrCollectionArray = [];
        $request = new QRPaymentCollection;
        if($this->data['user_id'] !=null){
            $request = $request->where('user_id',$this->data['user_id']);
         }
        if($this->data['start_date'] !=null && $this->data['end_date'] ==null){
            $request = $request->whereDate('created_at',$this->data['start_date']);
         }
        if($this->data['start_date'] !=null && $this->data['end_date'] !=null){
            $request = $request->whereDate('created_at','>=',$this->data['start_date'])->whereDate("created_at","<=",$this->data['end_date']);
         }
        if($this->data['value'] !=null){
            $request = $request->where('qr_code_id','like','%'.$this->data['value'].'%')
            ->orWhere('payment_amount','like','%'.$this->data['value'].'%')
            ->orWhere('payments_amount_received','like','%'.$this->data['value'].'%')
            ->orWhere('entity','like','%'.$this->data['value'].'%')
            ->orWhere('qr_status','like','%'.$this->data['value'].'%')
            ->orWhere('close_reason','like','%'.$this->data['value'].'%');
         }

         if (isset($this->data['status']) && $this->data['status'] != null) {
            $request = $request->where('status_id', $this->data['status']);
        }

        foreach($request->get() as $requests){
            $qrCollectionArray[]=[
                $requests->user->name,
                $requests->qr_code_id,
                $requests->payment_amount,
                $requests->payments_amount_received,
                $requests->entity,
                $requests->qr_status,
                $requests->close_reason,
                strip_tags($requests->status?->name),
                $requests->created_at,
                Carbon::parse( $requests->qrCollectionHistories?->created_at)->format('dS M Y'),
            ];
        };

        return collect($qrCollectionArray);
    }


    public function headings(): array
    {
        return ['ID',
            'QR ID',
            'Amount',
            'Received Amount',
            'Current Status',
            'QR Status',
            'QR Close Reason',
            'Status',
            'Date',
        'ExportDate'];
    }
}

