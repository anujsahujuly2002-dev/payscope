<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\APILog;
use App\Livewire\Admin\LogManager\ApiLogs;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class APILogExport implements FromCollection, WithHeadings
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
        $LoginSessionArray = [];
        $loginSession = new ApiLog;

         if($this->data['start_date'] !=null && $this->data['end_date'] ==null){
            $loginSession = $loginSession->whereDate('created_at',$this->data['start_date']);
         }
        if($this->data['start_date'] !=null && $this->data['end_date'] !=null){
            $loginSession = $loginSession->whereDate('created_at','>=',$this->data['start_date'])->whereDate("created_at","<=",$this->data['end_date']);
        }
        if($this->data['transaction_id'] !=null){
            $loginSession = $loginSession->where('txn_id','like','%'.$this->data['transaction_id'].'%');
        }


        foreach($loginSession->get() as $requests):
            $LoginSessionArray[]=[
                $requests->url,
                $requests->txn_id,
                $requests->header,
                $requests->request,
                Carbon::parse( $requests->loginSessionHistories?->created_at)->format('dS M Y'),
            ];
        endforeach;

        return collect($LoginSessionArray);
    }


    public function headings(): array
    {
        return ['Url','Transaction Id','Header','Request','Date'];
    }
}
