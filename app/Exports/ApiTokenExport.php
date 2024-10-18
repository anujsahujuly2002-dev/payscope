<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\ApiToken;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;


class ApiTokenExport implements FromCollection,WithHeadings
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
        $ApiTokenArray = [];
        $apiToken = new ApiToken;
        if($this->data['user_id'] !=null):
            $apiToken = $apiToken->where('user_id',$this->data['user_id']);
        endif;
        if($this->data['start_date'] !=null && $this->data['end_date'] ==null):
            $apiToken = $apiToken->whereDate('created_at',$this->data['start_date']);
        endif;
        if($this->data['start_date'] !=null && $this->data['end_date'] !=null):
            $apiToken = $apiToken->whereDate('created_at','>=',$this->data['start_date'])->whereDate("created_at","<=",$this->data['end_date']);
        endif;
        if($this->data['value'] !=null):
            $apiToken = $apiToken->where('order_id','like','%'.$this->data['value'].'%');
        endif;

        foreach($apiToken->get() as $requests):
            $ApiTokenArray[]=[
                $requests->user->name,
                $requests->ip_address,
                $requests->token,
                $requests->domain,
            ];
        endforeach;

        return collect($ApiTokenArray);
    }

    public function headings(): array
    {
        return ["Api Partner Name", "IP", "Token",'Domain'];
    }
}
