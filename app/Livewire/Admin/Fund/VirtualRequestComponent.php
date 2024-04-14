<?php

namespace App\Livewire\Admin\Fund;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\VirtualRequest;

class VirtualRequestComponent extends Component
{
   use  WithPagination;
    public function render()
    {
        $virtualRequests  = VirtualRequest::when(auth()->user()->getRoleNames()->first() !='super-admin',function($reports){
            $reports->where('user_id',auth()->user()->id);
        })->latest()->latest()->paginate(10);

        return view('livewire.admin.fund.virtual-request-component',compact('virtualRequests'));
    }
}
