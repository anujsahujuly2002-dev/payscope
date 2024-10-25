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
        if($this->data['user_id'] !=null):
            $request = $request->where('user_id',$this->data['user_id']);
        endif;
        if($this->data['start_date'] !=null && $this->data['end_date'] ==null):
            $request = $request->whereDate('created_at',$this->data['start_date']);
        endif;
        if($this->data['start_date'] !=null && $this->data['end_date'] !=null):
            $request = $request->whereDate('created_at','>=',$this->data['start_date'])->whereDate("created_at","<=",$this->data['end_date']);
        endif;
        if($this->data['value'] !=null):
            $request = $request->where('qr_code_id','like','%'.$this->data['value'].'%');
        endif;



        foreach($request->get() as $requests):
            $qrCollectionArray[]=[
                $requests->user_id,
                $requests->qr_code_id,
                $requests->amount,
                $requests->payments_amount_received,
                $requests->entity,
                $requests->qr_status,
                $requests->close_reason,
                strip_tags($requests->status?->name),
                Carbon::parse( $requests->qrCollectionHistories?->created_at)->format('dS M Y'),
            ];
        endforeach;

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
            'Date'];
    }
}

