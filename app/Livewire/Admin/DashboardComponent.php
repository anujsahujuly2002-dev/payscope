<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\LoginSession;
class DashboardComponent extends Component
{
    public function render()
    {
        $loginActivities = LoginSession::when(auth()->user()->getRoleNames()->first() !='super-admin',function($query){
            $query->where('user_id',auth()->user()->id);
        })
        ->with('user')->latest()->take(10)->get();
        return view('livewire.admin.dashboard-component',compact('loginActivities'));
    }
}
