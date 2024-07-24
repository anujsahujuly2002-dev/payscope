<?php

namespace App\Livewire\Admin\Fund;

use App\Models\Status;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\VirtualRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VirtualRequestExport;

class VirtualRequestComponent extends Component
{
    use  WithPagination;
    public $statuses = [];
    public $start_date;
    public $end_date;
    public $value;
    public $agentId;
    public $status;

    public function updated() {
        $this->resetPage();
    }

    public function render()
    {
        $this->statuses =  Status::get();
        $virtualRequests  = VirtualRequest::when(auth()->user()->getRoleNames()->first() !='super-admin',function($reports){
            $reports->where('user_id',auth()->user()->id);
        })->when($this->start_date !=null && $this->end_date ==null,function($u){
            $u->whereDate('created_at',$this->start_date);
        })
        ->when($this->start_date !=null && $this->end_date !=null,function($twoBetweenDates){
            $twoBetweenDates->whereDate('created_at','>=',$this->start_date)->whereDate("created_at","<=",$this->end_date);
        })
        ->when($this->status !=null,function($u){
            $u->where('status_id',$this->status);
        })
        ->when($this->agentId !=null,function($u){
            $u->where('user_id',$this->agentId);
        })
        ->when($this->value !=null,function($u){
            $u->where('reference_number', 'like', '%'.$this->value.'%')->orWhere('remitter_utr','like','%'.$this->value.'%');
        })->latest()->paginate(10);

        return view('livewire.admin.fund.virtual-request-component',compact('virtualRequests'));
    }

    public function export() {
        $data = [
            'user_id'=>auth()->user()->getRoleNames()->first() =='super-admin'?$this->agentId:auth()->user()->id,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'status'=>$this->status,
            'value'=>$this->value
        ];
        //  dd($data);
        return Excel::download(new VirtualRequestExport($data), time().'.xlsx');
    }
}
