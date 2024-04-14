<?php

namespace App\Livewire\Admin\LogManager;

use App\Models\ApiLog;
use Livewire\Component;
use Livewire\WithPagination;

class ApiLogs extends Component
{
    use WithPagination;
    public function render()
    {
        $apiLogs = ApiLog::latest()->paginate(10);
        return view('livewire.admin.log-manager.api-logs',compact('apiLogs'));
    }
}
