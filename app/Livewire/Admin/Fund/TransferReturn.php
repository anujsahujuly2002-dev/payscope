<?php

namespace App\Livewire\Admin\Fund;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\TransferReturn as WalletTransaction;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransferReturnExport;
use App\Models\QRRequest;
use App\Models\Wallet;
use Carbon\Carbon;

class TransferReturn extends Component
{
    use WithPagination;

    public $value = '';
    public $searchResults = [];
    public $selectedUser = null;
    public $selectedUserSearch = null;
    public $amount;
    public $transactionType = '';
    public $transactionFilter ;
    public $remark;
    public $utr_number;
    public $reference_number;
    public $uids;
    public $start_date;
    public $end_date;

    protected $rules = [
        'amount' => 'required|numeric|min:1',
        'transactionType' => 'required|in:1,2',
        'remark' => 'required|string|max:255'
    ];

    public function updated($field)
    {
        if ($field === 'value') {
            $this->resetPage();
        }
    }

    public function render(){
        $query = DB::table('transfer_returns')->select('*');
        if ($this->selectedUserSearch) {
            $userIds = User::where('name', 'like', '%' . $this->selectedUserSearch . '%')->orWhere('email', 'like', '%' . $this->selectedUserSearch . '%')->orWhere('mobile_no', 'like', '%' . $this->selectedUserSearch . '%')->pluck('id');
            $this->uids = $userIds;
            if ($userIds->isNotEmpty()) {
                $query->whereIn('user_id', $userIds);
            }
        }
        // Filter by date range
        if ($this->transactionFilter) {
            $query->where('transaction_type', $this->transactionFilter);
        }
        if ($this->start_date) {
            $query->whereDate('created_at', '>=', Carbon::parse($this->start_date));
        }
        if ($this->start_date) {
            $query->whereDate('created_at', '>=', Carbon::parse($this->start_date));
        }

        if ($this->end_date) {
            $query->whereDate('created_at', '<=', Carbon::parse($this->end_date));
        }
        if ($this->value) {
            $this->searchResults = User::where('name', 'like', '%' . $this->value . '%')->orWhere('email', 'like', '%' . $this->value . '%')->orWhere('mobile_no', 'like', '%' . $this->value . '%')->take(5) ->get();
        }

        // Fetch transactions with pagination
        $transactions = $query->paginate(10);
        return view('livewire.admin.fund.transfer-return', [
            'transactions' => $transactions
        ]);
    }


    public function getUserName($id)
    {
        $data = User::select('name')->where('id',$id)->first();
        return  $data->name;
    }
    public function getUserEmail($id)
    {
        $data = User::select('email')->where('id',$id)->first();
        return  $data->email;
    }
    public function getUserNumber($id)
    {
        $data = User::select('mobile_no')->where('id',$id)->first();
        return  $data->mobile_no;
    }

    private function createTransactionId()
    {
        do {
            $transactionId = 'GROSC' . rand(111111111111, 999999999999);
        } while (
            QRRequest::where('order_id', $transactionId)->exists() ||
            WalletTransaction::where('transaction_id', $transactionId)->exists()
        );

        return $transactionId;
    }


    public function selectUser($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->value = $this->selectedUser->name;
        $walletBalance = Wallet::where('user_id', $this->selectedUser->id)->value('amount');
        $this->selectedUser->wallet_balance = $walletBalance ?? 0;
        $this->searchResults = collect();
    }


    public function processTransaction()
    {
        $this->validate();
        if (!$this->selectedUser) {
            $this->addError('user', 'Please select a user first');
            return;
        }
        try {
            $userId = $this->selectedUser->id;
            $wallet = Wallet::where('user_id', $userId)->first();
            if (!$wallet) {
                $this->addError('wallet', 'User wallet not found');
                return;
            }
            $oldAmount = $wallet->amount;
            $newAmount = $this->transactionType == '1'? $oldAmount + $this->amount: $oldAmount - $this->amount;
            if ($this->transactionType == '2' && $oldAmount < $this->amount) {
                $this->addError('amount', 'Insufficient balance');
                $this->reset(['amount', 'transactionType', 'remark']);
                $this->selectUser($userId);
                return;
            }
            $transferReturn=WalletTransaction::create([
                'user_id' => $userId,
                'amount' => $this->amount,
                'remark' => $this->remark,
                'transaction_type' => $this->transactionType,
                'transaction_id' => $this->createTransactionId(),
                'utr_number' => $this->utr_number,
                'reference_number' => $this->reference_number,
                'status' => '2',
                'created_at' => now(),
            ]);

            $type =  $this->transactionType == '1'?"credit":"debit";
            addTransactionHistory($transferReturn->transaction_id,$transferReturn->user_id,$transferReturn->amount,$type);
            Wallet::where('user_id', $userId)->update([
                'amount' => $newAmount,
                'updated_at' => now()
            ]);
            $this->dispatch('hide-form');
            session()->flash('success', $this->transactionType == '1' ? 'Amount credited successfully' : 'Amount debited successfully');
            $this->selectUser($userId);

            $this->reset(['amount', 'transactionType', 'remark']);
            $this->dispatch('hide-form');

        } catch (\Exception $e) {
            session()->flash('error', 'Transaction failed: ' . $e->getMessage());
            $this->dispatch('hide-form');
        }
    }


    public function total_credit()
    {
        return WalletTransaction::where('transaction_type', 1)->sum('amount'); //
    }

    public function total_debit()
    {
        return WalletTransaction::where('transaction_type', 2)->sum('amount'); //
    }

    public function total_transactions()
    {
        return WalletTransaction::count();
    }

    public function export()
    {
        $filters = [
            'user_id' => $this->uids ? $this->uids : null,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'value' => $this->value,
            'transaction_type' => $this->transactionFilter
        ];

        return Excel::download(new TransferReturnExport($filters), 'transactions.xlsx');
    }

    public function clearUser()
    {
        $this->reset(['selectedUser', 'value', 'searchResults']);
        $this->resetErrorBag();

    }
    public function showForm() {
        $this->reset();
        $this->dispatch('show-form');
    }
}
