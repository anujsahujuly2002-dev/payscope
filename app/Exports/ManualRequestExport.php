<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Fund;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ManualRequestExport implements FromCollection,WithHeadings
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
        $fundsArray = [];
        $funds = new Fund;
        if ($this->data['user_id'] != null) {
            $funds = $funds->where('user_id', $this->data['user_id']);
        }
        if ($this->data['start_date'] != null && $this->data['end_date'] == null) {
            $funds = $funds->whereDate('created_at', $this->data['start_date']);
        }

        if ($this->data['start_date'] != null && $this->data['end_date'] != null) {
            $funds = $funds->whereDate('created_at', '>=', $this->data['start_date'])
                ->whereDate('created_at', '<=', $this->data['end_date']);
        }
        if ($this->data['value'] != null) {
            $funds = $funds->where('references_no', 'like', '%' . $this->data['value'] . '%')
                ->orWhere('pay_date', 'like', '%' . $this->data['value'] . '%')
                ->orWhere('opening_amount', 'like', '%' . $this->data['value'] . '%')
                ->orWhere('amount', 'like', '%' . $this->data['value'] . '%')
                ->orWhere('closing_amount', 'like', '%' . $this->data['value'] . '%')
                ->orWhere('remark', 'like', '%' . $this->data['value'] . '%');

            //Filter related 'paymentMode->name'
            if (isset($this->data['value'])) {
                $funds = $funds->whereHas('paymentMode', function ($query) {
                    $query->where('name', 'like', '%' . $this->data['value'] . '%');
                });
            }
        }

        if ($this->data['status'] != null) {
            $funds = $funds->where('status_id', $this->data['status']);
        }

        foreach ($funds->get() as $fund) {
            $fundsArray[] = [
                $fund->user->name,
                $fund->bank->name,
                $fund->bank->account_number,
                $fund->bank->branch_name,
                $fund->references_no,
                $fund->pay_date,
                $fund->paymentMode->name,
                $fund->opening_amount,
                $fund->amount,
                $fund->closing_amount,
                strip_tags($fund->status?->name),
                Carbon::parse($fund->manualTransactionHistories?->created_at)->format('dS M Y'),
            ];
        }

        return collect($fundsArray);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function headings(): array
    {
        return ["Name", "Bank Name", "Account Number",'Branch Name','Reference No.','Pay Date','Pay Mode','Opening Balance','Amount','Closing Balance','Status','Date'];
    }
}
