<?php

namespace App\Livewire\Admin\LogManager;

use Livewire\Component;
use App\Models\LoginSession;
use Livewire\WithPagination;

class LoginSessionComponent extends Component
{
    use WithPagination;
    public function render()
    {
        $loginSessions = LoginSession::when(auth()->user()->getRoleNames()->first()=='api-partner',function($q){
            $q->where('user_id',auth()->user()->id);
        })->when(auth()->user()->getRoleNames()->first()=='retailer',function($q){
            $q->where('user_id',auth()->user()->id);
        })
        ->latest()->paginate(10);
        return view('livewire.admin.log-manager.login-session-component',compact('loginSessions'));
    }
}
