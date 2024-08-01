<?php

namespace App\Livewire\Admin\RechargeAndBillPayment;

use App\Models\OperatorManager;
use Livewire\Component;

class MobileRechargeComponent extends Component
{

    public $currentForm = 'form1';

    public function showForm($form)
    {
        $this->currentForm = $form;
    }
        public $showModal = false;
        public $showModal1 = false;
        public $showModalEle = false;

    public function openModal()
    {
        $this->showModal = true;
        $this->showModal1 = false;
        $this->showModalEle = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
    public function openModal1()
    {
        $this->showModal1 = true;
        $this->showModal = false;
        $this->showModalEle = false;
    }

    public function closeModal1()
    {
        $this->showModal1 = false;
    }
    public function openModalEle()
    {
        $this->showModalEle = true;
        $this->showModal = false;
        $this->showModal1 = false;

    }

    public function closeModalEle()
    {
        $this->showModalEle = false;
    }

    public function render()
    {
        return view('livewire.admin.recharge-and-bill-payment.mobile-recharge-component');
    }
}

