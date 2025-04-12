<?php

namespace App\Livewire\Admin\LogManager;

use App\Exports\RazorpayAPILogExport;
use App\Models\RazorPayLog;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\PayoutRequestExport;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RazorpayApiLogs extends Component
{
    use WithPagination;
    public $start_date;
    public $end_date;
    public $value;
    public $status;
    public $user_id;

    public function render()
    {

        $apiLogs = RazorPayLog::when(auth()->user()->getRoleNames()->first()!='super-admin',function($query){
            $query->where('user_id',auth()->user()->id);
        })->when($this->start_date !=null && $this->end_date ==null,function($u){
            $u->whereDate('created_at',$this->start_date);
        })->when($this->start_date !=null && $this->end_date !=null,function($twoBetweenDates){
            $twoBetweenDates->whereDate('created_at','>=',$this->start_date)->whereDate("created_at","<=",$this->end_date);
        }) ->when($this->user_id !=null,function($u){
            $u->where('user_id',$this->user_id);
            // $u->where('txn_id',$this->transaction_id);

        })->when($this->value !=null,function($u){
            $u->where('payout_ref', 'like', '%'.$this->value.'%')->orWhere('payout_id','like','%'.$this->value.'%');
        })->latest()->paginate(100);
        return view('livewire.admin.log-manager.razorpay-api-logs',compact('apiLogs'));
    }


    public function export() {
        // dd(auth()->user()->getRoleNames()->first());
        $data = [
            'user_id'=>auth()->user()->getRoleNames()->first()!='super-admin'?$this->userid_id:NULL,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'value'=>$this->value,
        ];
        return Excel::download(new RazorpayAPILogExport($data), time().'.xlsx');
    }

}
