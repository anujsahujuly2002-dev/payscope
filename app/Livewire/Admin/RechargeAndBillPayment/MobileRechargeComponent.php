<?php

namespace App\Livewire\Admin\RechargeAndBillPayment;

use App\Models\OperatorManager;
use Livewire\Component;

class MobileRechargeComponent extends Component
{
    public $currentForm = 'form1';
    public $currentForm1 = 'form1';
    public $showSecondCard = false;

    public function showForm($form)
    {
        $this->currentForm = $form;
        $this->showSecondCard = true;

        if ($form === 'form1' || $form === 'form2') {
            $this->currentForm1 = ($form === 'form1') ? 'form1' : 'form2';

        } elseif ($form === 'form3' || $form === 'form4') {
            $this->showSecondCard = false;
        }
    }

    public function showForm1($form)
    {
        $this->currentForm1 = $form;
    }




    public function render()
    {
        return view('livewire.admin.recharge-and-bill-payment.mobile-recharge-component');
    }
}

