<?php

namespace App\Livewire\Admin\RechargeAndBillPayment;

use App\Models\MobileOpertor;
use App\Models\OperatorManager;
use Livewire\Component;

class MobileRechargeComponent extends Component
{
    protected $state=[];
    public function render()
    {
        
        $operators = MobileOpertor::get();
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
