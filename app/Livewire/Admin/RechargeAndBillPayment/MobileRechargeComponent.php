<?php

namespace App\Livewire\Admin\RechargeAndBillPayment;

use App\Models\OperatorManager;
use Livewire\Component;

class MobileRechargeComponent extends Component
{

    public $currentFormCard1 = 'form1';
    public $currentFormCard2 = 'form1';

    public function showFormCard1($form)
    {
        $this->currentFormCard1 = $form;
    }

    public function showFormCard2($form)
    {
        $this->currentFormCard2 = $form;
    }


    public $recharges = [
        ['amount' => 199, 'validity' => '28 Days', 'description' => '1.5GB/day, Unlimited Calls'],
        ['amount' => 399, 'validity' => '56 Days', 'description' => '2GB/day, Unlimited Calls, 100 SMS/day'],
        ['amount' => 599, 'validity' => '84 Days', 'description' => '3GB/day, Unlimited Calls, 100 SMS/day'],
    ];


    public function render()
    {
        return view('livewire.admin.recharge-and-bill-payment.mobile-recharge-component');
    }
}

