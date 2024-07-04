<?php

namespace App\Livewire\Admin;

use App\Models\Fund;
use Livewire\Component;
use App\Models\LoginSession;
use App\Models\PayoutRequestHistory;
use Spatie\Permission\Exceptions\UnauthorizedException;


class DashboardComponent extends Component
{
    public function render()
    {
        $data['loginActivities'] = LoginSession::with('user')->orderBy('created_at', 'desc')->take(10)->get();
        $data['payout'] = PayoutRequestHistory::when(auth()->user()->getRoleNames()->first() !='super-admin',function($q){
            $q->where('user_id',auth()->user()->id);
        })->where('status_id',2)->sum('amount');
        $data['paymentIn'] = Fund::when(auth()->user()->getRoleNames()->first() !='super-admin',function($v){
            $v->where('user_id',auth()->user()->id);
        })->where('status_id',2)->sum('amount');
        $data['rejectedPayment'] = PayoutRequestHistory::when(auth()->user()->getRoleNames()->first() !='super-admin',function($u){
            $u->where('user_id',auth()->user()->id);
        })->where('status_id',3)->sum('amount');
        $data['commission'] = PayoutRequestHistory::when(auth()->user()->getRoleNames()->first() !='super-admin',function($r){
            $r->where('user_id',auth()->user()->id);
        })->where('status_id',2)->sum('charge');
        return view('livewire.admin.dashboard-component',$data);
    }
}
