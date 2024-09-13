<?php

namespace App\Livewire\Admin\Member;

use Livewire\Component;

class DMTComponent extends Component
{

    public function create() {
        $this->reset();
        $this->dispatch('show-form');
    }


    public function render()
    {
        return view('livewire.admin.member.d-m-t-component');
    }
}
