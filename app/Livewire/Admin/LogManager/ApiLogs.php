<?php

namespace App\Livewire\Admin\LogManager;

use App\Exports\APILogExport;
use App\Models\ApiLog;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\PayoutRequestExport;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Exceptions\UnauthorizedException;


class ApiLogs extends Component
{
    use WithPagination;
    public $start_date;
    public $end_date;
    public $value;
    public $status;
    public $transaction_id;

    public function render()
    {

        $apiLogs = ApiLog::when(auth()->user()->getRoleNames()->first()=='api-logs',function($query){
            $query->where('user_id',auth()->user()->id);
        })->when(auth()->user()->getRoleNames()->first()=='login-session',function($query){
            $query->where('user_id',auth()->user()->id);

        })->when($this->start_date !=null && $this->end_date ==null,function($u){
            $u->whereDate('created_at',$this->start_date);

        })->when($this->start_date !=null && $this->end_date !=null,function($twoBetweenDates){
            $twoBetweenDates->whereDate('created_at','>=',$this->start_date)->whereDate("created_at","<=",$this->end_date);

        }) ->when($this->transaction_id !=null,function($u){
            $u->where('txn_id', 'like', '%'.$this->transaction_id.'%');
            // $u->where('txn_id',$this->transaction_id);

        })->when($this->value !=null,function($u){
            $u->where('payout_ref', 'like', '%'.$this->value.'%')->orWhere('payout_id','like','%'.$this->value.'%');
        })->latest()->paginate(10);
        return view('livewire.admin.log-manager.api-logs',compact('apiLogs'));
    }


    public function export() {
        $data = [
            'user_id'=>auth()->user()->getRoleNames()->first()!='api-logs'?$this->transaction_id:NULL,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'value'=>$this->value,
        ];
        return Excel::download(new APILogExport($data), time().'.xlsx');
    }
}
