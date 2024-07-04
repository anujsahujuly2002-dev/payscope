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
<<<<<<< HEAD
        $loginSessions = LoginSession::when(auth()->user()->getRoleNames()->first()=='api-partner',function($q){
            $q->where('user_id',auth()->user()->id);
        })->when(auth()->user()->getRoleNames()->first()=='retailer',function($q){
            $q->where('user_id',auth()->user()->id);
        })
        ->latest()->paginate(10);
=======
        $loginSessions = LoginSession::latest()->paginate(10);
>>>>>>> bde5cc6 (again setup)
        return view('livewire.admin.log-manager.login-session-component',compact('loginSessions'));
    }
}
