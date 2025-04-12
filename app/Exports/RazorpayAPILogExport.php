<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\RazorPayLog;
use App\Livewire\Admin\LogManager\RazorPayLogs;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RazorpayAPILogExport implements FromCollection, WithHeadings
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
        $loginSession = new RazorPayLog;
        if($this->data['user_id'] !=null):
            $loginSession = $loginSession->where('user_id',$this->data['user_id']);
        endif;
        if($this->data['start_date'] !=null && $this->data['end_date'] ==null):
            $loginSession = $loginSession->whereDate('created_at',$this->data['start_date']);
        endif;
        if($this->data['start_date'] !=null && $this->data['end_date'] !=null):
            $loginSession = $loginSession->whereDate('created_at','>=',$this->data['start_date'])->whereDate("created_at","<=",$this->data['end_date']);
        endif;
        if($this->data['value'] !=null):
            $loginSession = $loginSession->where('user_id','like','%'.$this->data['value'].'%');
        endif;


        foreach($loginSession->get() as $requests):
            $LoginSessionArray[]=[
                $requests->user_id,
                $requests->type,
                $requests->request,
                $requests->response,
                Carbon::parse( $requests->loginSessionHistories?->created_at)->format('dS M Y'),
            ];
        endforeach;

        return collect($LoginSessionArray);
    }


    public function headings(): array
    {
        return ['User Id','type','Request','Response'];
    }
}
