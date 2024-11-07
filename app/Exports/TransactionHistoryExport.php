<?php

namespace App\Exports;
use Carbon\Carbon;
use App\Models\TransactionHistory;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionHistoryExport implements FromCollection,WithHeadings
{
    public $data;

    public function __construct($data){
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $transactionHistoryQuery = TransactionHistory::with('user');

        if ($this->data['user_id'] != null) {
            $transactionHistoryQuery->where('user_id', $this->data['user_id']);
        }

        if ($this->data['start_date'] != null) {
            $transactionHistoryQuery->whereDate('created_at', '>=', $this->data['start_date']);
        }

        if ($this->data['end_date'] != null) {
            $transactionHistoryQuery->whereDate('created_at', '<=', $this->data['end_date']);
        }

        if ($this->data['value'] != null) {
            $transactionHistoryQuery->where('order_id', 'like', '%' . $this->data['value'] . '%');
        }

        $transactionHistory = $transactionHistoryQuery->get()->map(function ($request) {
            return [
                $request->user->name,
                $request->transaction_id,
                $request->opening_balance,
                $request->amount,
                $request->closing_balnce,
                $request->transaction_type,
                Carbon::parse($request->created_at)->format('dS M Y'),
            ];
        });

        return $transactionHistory;
    }


    public function headings(): array
    {
        return ['User Id','Transaction Id','Opening Balance','Amount','Closing Balance','Transaction Type','Date'];
    }
}
