<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\FundRequest;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PayoutRequestExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $fundRequestArray = [];
        $fundRequests =  FundRequest::get();
        foreach($fundRequests as $fundRequest):
            $fundRequestArray[]=[
                $fundRequest->user->name,
                $fundRequest->payout_id,
                $fundRequest->payout_ref,
                $fundRequest->payoutTransactionHistories?->balance??"0",
                $fundRequest->payoutTransactionHistories?->amount??"0",
                $fundRequest->payoutTransactionHistories?->charge??"0",
                $fundRequest->payoutTransactionHistories?->closing_balnce??"0",
               strip_tags($fundRequest->status?->name),
                Carbon::parse( $fundRequest->payoutTransactionHistories?->created_at)->format('dS M Y'),
            ];
        endforeach;
        return collect($fundRequestArray);
    }


    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["Name", "Payout Id", "Payment Reference Number",'Opening Amount','Order Amount','Charges','Closing Balance','Status','Date'];
    }
}
