<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\QRRequest;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class QRRequestExport implements FromCollection,WithHeadings
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
        $request = QRRequest::with('user');
        $qrRequestArray = [];
        $request = new QRRequest;
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
            $request = $request->where('order_id','like','%'.$this->data['value'].'%');
        endif;


        foreach($request->get() as $requests):
            $qrRequestArray[]=[
                $requests->user->name,
                $requests->order_id,
                $requests->qrRequest?->order_amount,
                $requests->walletAmount?->amount,
                $requests->closing_amount,
                strip_tags($requests->status?->name),
                Carbon::parse( $requests->qrRequestHistories?->created_at)->format('dS M Y'),
            ];
        endforeach;

        return collect($qrRequestArray);
    }


    public function headings(): array
    {
        return ['Name','Order Id','Opening Amount','Order Amount','Closing Amount','Status','Date'];
    }
}
