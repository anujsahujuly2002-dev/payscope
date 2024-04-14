<?php

namespace App\Livewire\Admin\RechargeAndBillPayment;

use App\Models\OperatorManager;
use Livewire\Component;

class MobileRechargeComponent extends Component
{
    protected $state=[];
    public function render()
    {
        
        $telecomeCicles = getTelecomCircles();
        dd($telecomeCicles);
        $operators = OperatorManager::where(['operator_type'=>'mobile','status'=>'1'])->get();
        return view('livewire.admin.recharge-and-bill-payment.mobile-recharge-component',compact('operators'));
    }

    public function create() {
        $this->reset();
        $this->dispatch('show-form');
    }

    public function getPlan($telecomeCircle) {
        dd($telecomeCircle);
    }
}
