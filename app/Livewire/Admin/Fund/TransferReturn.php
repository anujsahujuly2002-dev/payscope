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

    public function render()
{
    // Default query from transfer_returns table
    $query = DB::table('transfer_returns')->select('*');

    // Filter by selected user if set
    // if ($this->selectedUserSearch) {
    //     $query->where('user_id', $this->selectedUser->id);
    // }
    if ($this->selectedUserSearch) {
        // Get user IDs matching the search value
        $userIds = User::where('name', 'like', '%' . $this->selectedUserSearch . '%')
            ->orWhere('email', 'like', '%' . $this->selectedUserSearch . '%')
            ->orWhere('mobile_no', 'like', '%' . $this->selectedUserSearch . '%')
            ->pluck('id'); // Extracts only the 'id' column as an array
        $this->uids = $userIds;
        // Apply filter to the query if user IDs are found
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

    // Perform search if value exists
    if ($this->value) {
        $this->searchResults = User::where('name', 'like', '%' . $this->value . '%')
            ->orWhere('email', 'like', '%' . $this->value . '%')
            ->orWhere('mobile_no', 'like', '%' . $this->value . '%')
            ->take(5)
            ->get();
    }

    // Fetch transactions with pagination
    $transactions = $query->paginate(10);
    // $transactions['name'] = DB::table('users')->select('name')->where('id',$transactions->user_id)->first();
    // $transactions['email'] = DB::table('users')->select('email')->where('id',$transactions->user_id)->first();
    // $transactions['mobile_no'] = DB::table('users')->select('mobile')->where('id',$transactions->user_id)->first();

    return view('livewire.admin.fund.transfer-return', [
        'transactions' => $transactions
    ]);
}


    public function getUserName($id)
    {
        $data = DB::table('users')->select('name')->where('id',$id)->first();
        // dd($userName);
        return  $data->name;
        // return 'Harry';
    }
    public function getUserEmail($id)
    {
        $data = DB::table('users')->select('email')->where('id',$id)->first();
        // dd($userName);
        return  $data->email;
        // return 'Harry';
    }
    public function getUserNumber($id)
    {
        $data = DB::table('users')->select('mobile_no')->where('id',$id)->first();
        // dd($userName);
        return  $data->mobile_no;
        // return 'Harry';
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
        $walletBalance = DB::table('wallets')
            ->where('user_id', $this->selectedUser->id)
            ->value('amount');
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
            DB::beginTransaction();

            $userId = $this->selectedUser->id;
            $wallet = DB::table('wallets')->where('user_id', $userId)->lockForUpdate()->first();

            if (!$wallet) {
                $this->addError('wallet', 'User wallet not found');
                DB::rollBack();
                return;
            }

            $oldAmount = $wallet->amount;
            $newAmount = $this->transactionType == '1'
                ? $oldAmount + $this->amount
                : $oldAmount - $this->amount;

            if ($this->transactionType == '2' && $oldAmount < $this->amount) {
                $this->addError('amount', 'Insufficient balance');
                DB::rollBack();
                $this->reset(['amount', 'transactionType', 'remark']);
                $this->selectUser($userId);
                return;
            }
            // dd($newAmount);
            $updated = DB::table('wallets')
                ->where('user_id', $userId)
                ->update([
                    'amount' => $newAmount,
                    'updated_at' => now()
                ]);

            if (!$updated) {
                throw new \Exception('Failed to update wallet balance');
            }

            WalletTransaction::create([
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

            DB::commit();

            $this->dispatch('wallet-updated');
            session()->flash('success', $this->transactionType == '1' ? 'Amount credited successfully' : 'Amount debited successfully');

            // Refresh user wallet balance
            $this->selectUser($userId);

            $this->reset(['amount', 'transactionType', 'remark']);
            $this->dispatch('show-form');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Transaction failed: ' . $e->getMessage());
            \Log::error('Transaction failed: ' . $e->getMessage());
        }
    }


    public function total_credit()
    {
        return DB::table('transfer_returns') // Ensure the correct table name
            ->where('transaction_type', 1)
            ->sum('amount'); //
    }
    public function total_debit()
    {
        return DB::table('transfer_returns') // Ensure the correct table name
            ->where('transaction_type', 2)
            ->sum('amount'); //
    }
    public function total_transactions()
    {
        return DB::table('transfer_returns') // Ensure the correct table name

        ->count();
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
