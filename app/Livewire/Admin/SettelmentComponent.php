<?php

namespace App\Livewire\Admin;

use App\Models\Settelment;
use Livewire\Component;
use Livewire\WithPagination;

class SettelmentComponent extends Component
{
    use WithPagination;
    public $start_date;
    public $end_date;
    public $value;
    public $status;
    public $transaction_id;
    public function render()
    {
        $settelments = Settelment::when(auth()->user()->getRoleNames()->first() !='super-admin',function($query){
            $query->where('user_id',auth()->user()->id);
        })->when($this->start_date !=null && $this->end_date ==null,function($u){
            $u->whereDate('created_at',$this->start_date);

        })->when($this->start_date !=null && $this->end_date !=null,function($twoBetweenDates){
            $twoBetweenDates->whereDate('created_at','>=',$this->start_date)->whereDate("created_at","<=",$this->end_date);

        }) ->when($this->transaction_id !=null,function($u){
            $u->where('settelment_id', 'like', '%'.$this->transaction_id.'%');
            // $u->where('txn_id',$this->transaction_id);

        })
        // ->when($this->value !=null,function($u){
        //     $u->where('payout_ref', 'like', '%'.$this->value.'%')->orWhere('payout_id','like','%'.$this->value.'%');
        // })
        ->latest()->paginate(100);
        return view('livewire.admin.settelment-component',compact('settelments'));
    }
    
}
