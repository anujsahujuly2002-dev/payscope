<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\LoginSession;
class DashboardComponent extends Component
{
    public function render()
    {
        $data['data'] = LoginSession::with('user')->orderBy('created_at', 'desc')->get();
        return view('livewire.admin.dashboard-component',$data);
    }
}
