<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Fund;
use App\Models\Status;
use Livewire\Component;
use App\Models\QRRequest;
use App\Models\FundRequest;
use App\Models\PaymentMode;
use App\Models\LoginSession;
use App\Models\QRPaymentCollection;
use App\Models\PayoutRequestHistory;

class DashboardComponent extends Component
{
    // public $recentTransactions ;
    public $selectedTransaction;
    public $statuses;
    public $banks;
    public $paymentModes;

            public function render()
            {
                // Fetch other necessary data
                $loginActivities = LoginSession::when(auth()->user()->getRoleNames()->first() != 'super-admin', function($query) {
                    $query->where('user_id', auth()->user()->id);
                })->with('user')->orderBy('created_at', 'desc')->take(10)->get();

                $totalPaymenUsingQrReqesttIn = QRRequest::when(auth()->user()->getRoleNames()->first() != 'super-admin', function($query) {
                    $query->where('user_id', auth()->user()->id);
                })->where('status_id', '2')->sum('order_amount');

                $totalPaymenUsingQrCodetIn = QRPaymentCollection::when(auth()->user()->getRoleNames()->first() != 'super-admin', function($query) {
                    $query->where('user_id', auth()->user()->id);
                })->where('status_id', '2')->sum('payment_amount');

                $totalPaymenInManual = Fund::when(auth()->user()->getRoleNames()->first() != 'super-admin', function($query) {
                    $query->where('user_id', auth()->user()->id);
                })->where('status_id', '2')->sum('amount');

                $totalAmountPayIn = $totalPaymenUsingQrReqesttIn + $totalPaymenInManual + $totalPaymenUsingQrCodetIn;

                $totalPayOut = FundRequest::when(auth()->user()->getRoleNames()->first() != 'super-admin', function($query) {
                    $query->where('user_id', auth()->user()->id);
                })->where('status_id', '2')->sum('amount');

                $totalCommission = PayoutRequestHistory::when(auth()->user()->getRoleNames()->first() != 'super-admin', function($query) {
                    $query->where('user_id', auth()->user()->id);
                })->where('status_id', '2')->sum('charge');

                $totalPayOutToday = FundRequest::when(auth()->user()->getRoleNames()->first() != 'super-admin', function($query) {
                    $query->where('user_id', auth()->user()->id);
                })->whereDate('created_at', Carbon::parse(now())->format('Y-m-d'))->where('status_id', '2')->sum('amount');

                $recentPayoutHistory = PayoutRequestHistory::when(auth()->user()->getRoleNames()->first() != 'super-admin', function($query) {
                    $query->where('user_id', auth()->user()->id);
                })->orderBy('created_at', 'desc')->take(10)->get();

                // Pass the class property $recentTransactions directly to the view
                return view('livewire.admin.dashboard-component', compact(
                    'loginActivities',
                    'totalAmountPayIn',
                    'totalPayOut',
                    'totalCommission',
                    'totalPayOutToday',
                    'recentPayoutHistory'
                ));
            }


    public function transaction($transactionId){

        $this->selectedTransaction = PayoutRequestHistory::find($transactionId);
        $this->dispatch('show-form');
    }

}
