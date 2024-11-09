<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Retailer;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class RetailerExport implements FromCollection,WithHeadings
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
        $retailerArray = [];

        $retailers = User::whereHas('roles', function ($query) {
            $query->where('name', 'retailer');
        });

        if (isset($this->data['user_id']) && $this->data['user_id'] != null) {
            $retailers = $retailers->where('id', $this->data['user_id']);
        }

        if (isset($this->data['start_date']) && $this->data['start_date'] != null && $this->data['end_date'] == null) {
            $retailers = $retailers->whereDate('created_at', $this->data['start_date']);
        }

        if (isset($this->data['start_date']) && $this->data['start_date'] != null && isset($this->data['end_date']) && $this->data['end_date'] != null) {
            $retailers = $retailers->whereDate('created_at', '>=', $this->data['start_date'])
                ->whereDate('created_at', '<=', $this->data['end_date']);
        }

        if (isset($this->data['value']) && $this->data['value'] != null) {
            $retailers = $retailers->where(function ($query) {
                $query->where('mobile_no', 'like', '%' . $this->data['value'] . '%')
                    ->orWhere('address', 'like', '%' . $this->data['value'] . '%')
                    ->orWhere('city', 'like', '%' . $this->data['value'] . '%')
                    ->orWhere('state', 'like', '%' . $this->data['value'] . '%')
                    ->orWhere('pincode', 'like', '%' . $this->data['value'] . '%')
                    ->orWhere('shop_name', 'like', '%' . $this->data['value'] . '%')
                    ->orWhere('pancard_number', 'like', '%' . $this->data['value'] . '%')
                    ->orWhere('adhaarcard_number', 'like', '%' . $this->data['value'] . '%');
            });
        }
        $exportDate = Carbon::now()->format('Y-m-d');

        foreach ($retailers->get() as $retailer) {
            $retailerArray[] = [
                $retailer->name,
                $retailer->mobile_no,
                ucfirst($retailer->getRoleNames()->first()),
                $retailer->retailer?->shop_name,
                $retailer->walletAmount?->amount,
                $retailer->status,
                $retailer->created_at,
                $exportDate,
               ];
        }

        // Return the array as a collection
        return collect($retailerArray);
    }


    public function headings(): array
    {
        return ['Name', 'Mobile No.','Role','Company','Wallet Amount','Status','Date', 'ExportDate'];
    }

  }

