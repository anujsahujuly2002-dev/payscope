<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\LoginSession;
class DashboardComponent extends Component
{
    public function render()
    {
        $loginActivities = LoginSession::with('user')->orderBy('created_at', 'desc')->take(10)->get();
        return view('livewire.admin.dashboard-component',compact('loginActivities'));
    }
}
