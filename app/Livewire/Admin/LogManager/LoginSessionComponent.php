<?php

namespace App\Livewire\Admin\LogManager;

use Livewire\Component;
use App\Models\LoginSession;
use Livewire\WithPagination;

class LoginSessionComponent extends Component
{
    use WithPagination;

    public $start_date;
    public $value;
    public $end_date;
    public $agentId;
    // public $userName;
    public function render()
    {
        $loginSessions = LoginSession::when(auth()->user()->getRoleNames()->first()=='api-partner',function($q){
            $q->where('user_id',auth()->user()->id);
        })->when(auth()->user()->getRoleNames()->first()=='retailer',function($q){
            $q->where('user_id',auth()->user()->id);
        })->when(auth()->user()->getRoleNames()->first()=='retailer',function($query){
            $query->where('user_id',auth()->user()->id);
        })->when($this->start_date !=null && $this->end_date ==null,function($u){
            $u->whereDate('created_at',$this->start_date);
        })->when($this->start_date !=null && $this->end_date !=null,function($twoBetweenDates){
            $twoBetweenDates->whereDate('created_at','>=',$this->start_date)->whereDate("created_at","<=",$this->end_date);
        })->when($this->agentId !=null,function($u){
            $u->where('user_id',$this->agentId);
        })->when($this->value !=null,function($u){
            $u->where('ip_address',$this->value);
        // })->when($this->value !=null,function($u){
        //     $u->where('name',$this->userName);
        })->latest()->paginate(10);
        return view('livewire.admin.log-manager.login-session-component',compact('loginSessions'));
    }


    public function export() {
        $data = [
            'user_id'=>auth()->user()->getRoleNames()->first() =='super-admin'?$this->agentId:auth()->user()->id,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'value'=>$this->value,
        ];
        //  dd($data);
        return Excel::download(new LoginSessionExport($data), time().'.xlsx');
    }
}
