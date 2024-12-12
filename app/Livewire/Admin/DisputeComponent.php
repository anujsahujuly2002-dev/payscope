<?php

namespace App\Livewire\Admin;

use App\Models\Dispute;
use Livewire\Component;
use Livewire\WithPagination;

class DisputeComponent extends Component
{
    use WithPagination;
    public $start_date, $end_date, $status, $dispute_id;
    
    public function render()
    {
        $disputes = Dispute::when(auth()->user()->getRoleNames()->first() !='super-admin',function($query){
            $query->where('user_id',auth()->user()->id);
        })->when($this->start_date !=null && $this->end_date ==null,function($u){
            $u->whereDate('created_at_razorpay',$this->start_date);

        })->when($this->start_date !=null && $this->end_date !=null,function($twoBetweenDates){
            $twoBetweenDates->whereDate('created_at_razorpay','>=',$this->start_date)->whereDate("created_at_razorpay","<=",$this->end_date);

        }) ->when($this->dispute_id !=null,function($u){
            $u->where('dispute_id', 'like', '%'.$this->dispute_id.'%')->orWhere('payment_id', 'like', '%'.$this->dispute_id.'%');
        })->orderBy('created_at_razorpay','DESC')->paginate(100);
        return view('livewire.admin.dispute-component',compact('disputes'));
    }
}
