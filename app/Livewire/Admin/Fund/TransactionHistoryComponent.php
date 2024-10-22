<?php

namespace App\Livewire\Admin\Fund;

use App\Models\Status;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\TransactionHistory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionHistoryExport;

class TransactionHistoryComponent extends Component
{
    use WithFileUploads,WithPagination;
    public $start_date;
    public $end_date;
    public $agentId;
    public $statuses = [];
    public $value;
    public $payment =[];

    public function render()
    {
        $transaction_history = TransactionHistory::query()
            ->when(auth()->user()->getRoleNames()->first() == 'api-partner', function($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->when(auth()->user()->getRoleNames()->first() == 'retailer', function($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->when($this->start_date && $this->end_date, function($query) {
                $query->whereDate('created_at', '>=', $this->start_date)
                      ->whereDate('created_at', '<=', $this->end_date);
            })
            ->when($this->agentId, function($query) {
                $query->where('user_id', $this->agentId);
            })
            ->when($this->start_date && !$this->end_date, function($query) {
                $query->whereDate('created_at', '>=', $this->start_date);
            })
            ->when($this->value, function($query) {
                $query->where('transaction_id', $this->value);
            })
            ->latest()->paginate(100);
        return view('livewire.admin.fund.transaction-history-component',[
          'transaction_history'=> $transaction_history
        ]);
    }

    public function export() {
        $data = [
            'user_id'=>auth()->user()->getRoleNames()->first() =='super-admin'?$this->agentId:auth()->user()->id,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'value'=>$this->value
        ];
        return Excel::download(new TransactionHistoryExport($data), time().'.xlsx');
    }
}
