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
        $loginSessions = LoginSession::latest()->paginate(10);
        return view('livewire.admin.log-manager.login-session-component',compact('loginSessions'));
    }
}
