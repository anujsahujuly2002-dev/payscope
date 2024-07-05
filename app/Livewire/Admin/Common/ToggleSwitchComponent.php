<?php

namespace App\Livewire\Admin\Common;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

class ToggleSwitchComponent extends Component
{
    public Model $model;
    public string $field;
    public bool $status;
    public function mount()
    { 
        $this->status = (bool) $this->model->getAttribute($this->field);
    }
    public function render()
    {
        return view('livewire.admin.common.toggle-switch-component');
    }

    
    public function updating($field, $value)
    {
        $this->model->setAttribute($field,$value)->save();
        if($value):
            return redirect()->back()->with('success','Api Partner Has Been Activate !');
        else:
            return redirect()->back()->with('error','Api Partner Has Been InActivate !');
        endif;

    }
}
