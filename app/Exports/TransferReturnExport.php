<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Transfer_Return;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransferReturnExport implements FromCollection, WithHeadings
{

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Transfer_Return::query();

        if (!empty($this->data['user_id'])) {
            if (is_array($this->data['user_id'])) {
                $query->whereIn('user_id', $this->data['user_id']); // Handle multiple IDs
            } else {
                $query->where('user_id', $this->data['user_id']); // Handle single ID
            }
        }


        if (!empty($this->data['start_date'])) {
            $query->whereDate('created_at', '>=', $this->data['start_date']);
        }

        if (!empty($this->data['end_date'])) {
            $query->whereDate('created_at', '<=', $this->data['end_date']);
        }

        if (!empty($this->data['transaction_type'])) {
            $query->where('transaction_type', $this->data['transaction_type']);
        }

        $transactions = $query->get()->map(function ($transaction) {
            return [
                'User Name' => User::find($transaction->user_id)->name ?? 'N/A',
                'User Email' => User::find($transaction->user_id)->email ?? 'N/A',
                'Transaction ID' => $transaction->id,
                'Amount' => $transaction->amount,
                'Transaction Type' => $transaction->transaction_type == 1 ? 'Credited' : 'Debited',
                'Remark' => $transaction->remark,
                'Status' => ucfirst($transaction->status),
                'Date' => Carbon::parse($transaction->created_at)->format('d M Y h:i A'),
            ];
        });

        return $transactions;
    }

    public function headings(): array
    {
        return ['User Name', 'User Email', 'Transaction ID', 'Amount', 'Transaction Type', 'Remark', 'Status', 'Date'];
    }
}
