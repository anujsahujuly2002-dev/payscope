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
        $qrRequestArray = [];
        $request = new QRRequest;
        if ($this->data['user_id'] != null) {
            $request = $request->where('user_id', $this->data['user_id']);
        }
        if ($this->data['start_date'] != null && $this->data['end_date'] == null) {
            $request = $request->whereDate('created_at', $this->data['start_date']);
        }

        if ($this->data['start_date'] != null && $this->data['end_date'] != null) {
            $request = $request->whereDate('created_at', '>=', $this->data['start_date'])
                ->whereDate('created_at', '<=', $this->data['end_date']);
        }
        if($this->data['value'] !=null){
            $request = $request->where('order_id','like','%'.$this->data['value'].'%')
            ->orWhere('order_amount','like','%'.$this->data['value'].'%')
            ->orWhere('amount','like','%'.$this->data['value'].'%')
            ->orWhere('closing_amount','like','%'.$this->data['value'].'%');
        }

        if (isset($this->data['status']) && $this->data['status'] != null) {
            $request = $request->where('status_id', $this->data['status']);
        }

        foreach($request->get() as $requests){
            $qrRequestArray[]=[
                $requests->user->name,
                $requests->order_id,
                $requests->opening_amount,
                $requests->order_amount,
                $requests->closing_amount,
                strip_tags($requests->status?->name),
                $requests->created_at,
                Carbon::parse( $requests->qrRequestHistories?->created_at)->format('dS M Y'),

            ];
        }

        return collect($qrRequestArray);
    }


    public function headings(): array
    {
        return ['Name','Order Id','Opening Amount','Order Amount','Closing Amount','Status','Date','ExportDate'];
    }
}
