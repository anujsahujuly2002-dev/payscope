<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\VirtualRequest;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class VirtualRequestExport implements FromCollection,WithHeadings
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
        $virtualRequestArray = [];
        $virtualRequest = new VirtualRequest;
        if ($this->data['user_id'] != null) {
            $virtualRequest = $virtualRequest->where('user_id', $this->data['user_id']);
        }
        if ($this->data['start_date'] != null && $this->data['end_date'] == null) {
            $virtualRequest = $virtualRequest->whereDate('created_at', $this->data['start_date']);
        }
        if ($this->data['start_date'] != null && $this->data['end_date'] != null) {
            $virtualRequest = $virtualRequest->whereDate('created_at', '>=', $this->data['start_date'])
                ->whereDate("created_at", "<=", $this->data['end_date']);
        }
        if ($this->data['value'] != null) {
            $virtualRequest = $virtualRequest->where('credit_time', 'like', '%' . $this->data['value'] . '%')
                ->orWhere('remitter_name', 'like', '%' . $this->data['value'] . '%')
                ->orWhere('remitter_account_number', 'like', '%' . $this->data['value'] . '%')
                ->orWhere('remitter_ifsc_code', 'like', '%' . $this->data['value'] . '%')
                ->orWhere('reference_number', 'like', '%' . $this->data['value'] . '%')
                ->orWhere('remitter_utr', 'like', '%' . $this->data['value'] . '%')
                ->orWhere('opening_amount', 'like', '%' . $this->data['value'] . '%')
                ->orWhere('credit_amount', 'like', '%' . $this->data['value'] . '%')
                ->orWhere('closing_amount', 'like', '%' . $this->data['value'] . '%');

            // Filter virtual_account_number in user model
            $virtualRequest = $virtualRequest->orWhereHas('user', function ($query) {
                $query->where('virtual_account_number', 'like', '%' . $this->data['value'] . '%');
            });
        }
        if ($this->data['status'] != null) {
            $virtualRequest = $virtualRequest->where('status_id', $this->data['status']);
        }

        $virtualRequest = $virtualRequest->with('user');

        foreach ($virtualRequest->get() as $virtualRequests) {
            $virtualRequestArray[] = [
                $virtualRequests->user->name,
                $virtualRequests->user->virtual_account_number,
                $virtualRequests->remitter_name,
                $virtualRequests->remitter_account_number,
                $virtualRequests->remitter_ifsc_code,
                $virtualRequests->reference_number,
                $virtualRequests->remitter_utr,
                $virtualRequests->opening_amount,
                $virtualRequests->credit_amount,
                $virtualRequests->closing_amount,
                strip_tags($virtualRequests->status?->name),
                $virtualRequests->created_at,
                Carbon::parse($virtualRequests->virtualTransactionHistories?->created_at)->format('dS M Y'),
            ];
        }

        // Return the collection
        return collect($virtualRequestArray);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function headings(): array
    {
        return ['Name', 'Account Number','Remitter Name','Remitter Account Number','Remitter IFSC Code','Reference No.','Remitter UTR','Opening Amount','Credit Amount','Closing Amount','Status','Date','ExportDate'];
    }
}
