<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\LoginSession;
use App\Models\Fund;
use App\Models\PayoutRequestHistory;


class DashboardComponent extends Component
{
    public function render()
    {
        $data['loginActivities'] = LoginSession::with('user')->orderBy('created_at', 'desc')->take(10)->get();
        $data['payout'] = PayoutRequestHistory::sum('amount');
        $data['paymentIn'] = Fund::where('status_id',2)->sum('amount');
        $data['rejectedPayment'] = Fund::where('status_id',3)->sum('amount');
        $data['commission'] = PayoutRequestHistory::where('status_id',2)->sum('charge');
        return view('livewire.admin.dashboard-component',$data);
    }
}
