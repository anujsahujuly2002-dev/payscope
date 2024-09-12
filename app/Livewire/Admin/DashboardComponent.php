<?php

namespace App\Livewire\Admin;

use App\Models\Bank;
use App\Models\Fund;
use App\Models\Status;
use Livewire\Component;
use App\Models\FundRequest;
use App\Models\PaymentMode;
use App\Models\LoginSession;
use App\Models\PayoutRequestHistory;

class DashboardComponent extends Component
{
    public $paymentIn;
    public $payout;
    public $rejectedPayment;
    public $commission;
    public $recentTransactions =null;
    public $selectedTransaction;
    public $statuses;
    public $banks;
    public $paymentModes;


    public function calculateAmounts()
       {
            $paymentIn = Fund::when(auth()->user()->getRoleNames()->first() != 'super-admin', function ($v) {
                $v->where('user_id', auth()->user()->id);
            })->where('status_id', 2)->sum('amount');

            $payout = PayoutRequestHistory::when(auth()->user()->getRoleNames()->first() != 'super-admin', function ($q) {
                $q->where('user_id', auth()->user()->id);
            })->where('status_id', 2)->sum('amount');

            $rejectedPayment = PayoutRequestHistory::when(auth()->user()->getRoleNames()->first() != 'super-admin', function ($u) {
                $u->where('user_id', auth()->user()->id);
            })->where('status_id', 3)->sum('amount');

            $commission = PayoutRequestHistory::when(auth()->user()->getRoleNames()->first() != 'super-admin', function ($r) {
                $r->where('user_id', auth()->user()->id);
            })->where('status_id', 2)->sum('charge');

            $this->paymentIn = formatAmount($paymentIn);
            $this->payout = formatAmount($payout);
            $this->rejectedPayment = formatAmount($rejectedPayment);
            $this->commission = formatAmount($commission);
       }


    public function render()
        {
            if (auth()->user()->hasRole('admin')) {
                $data['loginActivities'] = LoginSession::with('user')
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();
            } else {
                $data['loginActivities'] = LoginSession::with('user')
                    ->where('user_id', auth()->user()->id)
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();
            }

            $data['paymentIn'] = $this->paymentIn;
            $data['payout'] = $this->payout;
            $data['rejectedPayment'] = $this->rejectedPayment;
            $data['commission'] = $this->commission;

            return view('livewire.admin.dashboard-component', $data);
        }


    public function mount()
        {
            $this->recentTransactions = PayoutRequestHistory::with('user', 'status','fund')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
                if ($this->recentTransactions->isEmpty()) {
                    $this->recentTransactions = collect();
                }
            $this->calculateAmounts();
            // dd($this->recentTransactions);
        }


        public function transaction($transactionId)
          {
            $this->paymentModes = PaymentMode::whereIn('id',['1','2'])->get();
            $this->banks = Bank::get();
            $this->statuses =  Status::get();
             $this->selectedTransaction = PayoutRequestHistory::with('user', 'status','funds')->findOrFail($transactionId);
             $this->dispatch('show-form');
          }
}
