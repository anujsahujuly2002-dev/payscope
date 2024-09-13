<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\LoginSession;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LoginSessionExport implements FromCollection, WithHeadings
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
        $loginSessionsArray = [];
        $loginSession = new LoginSession;
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
            $loginSession = $loginSession->where('order_id','like','%'.$this->data['value'].'%');
        endif;

        foreach($loginSession->get() as $requests):
            $loginSessionsArray[]=[
                $requests->user->name,
                $requests->latitude,
                $requests->logitude,
                $requests->ip_address,
                $requests->login_time,
                $requests->is_logged_in ==0?"Login":"Logout",
                $requests->logout_time,
            ];
        endforeach;

        return collect($loginSessionsArray);
    }

    public function headings(): array
    {
        return ["Name", "Latitude", "Logitude",'IP Address ','Login Time','Is Logged In ','Logout Time'];
    }
}
