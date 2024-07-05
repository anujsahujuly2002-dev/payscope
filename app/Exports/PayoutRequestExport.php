<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\FundRequest;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PayoutRequestExport implements FromCollection,WithHeadings
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
        $fundRequestArray = [];
        $fundRequests = new FundRequest;
        if($this->data['user_id'] !=null):
            $fundRequests = $fundRequests->where('user_id',$this->data['user_id']);
        endif;
        if($this->data['start_date'] !=null && $this->data['end_date'] ==null):
            $fundRequests = $fundRequests->whereDate('created_at',$this->data['start_date']);
        endif;
        if($this->data['start_date'] !=null && $this->data['end_date'] !=null):
            $fundRequests = $fundRequests->whereDate('created_at','>=',$this->data['start_date'])->whereDate("created_at","<=",$this->data['end_date']);
        endif;
        if($this->data['value'] !=null):
            $fundRequests = $fundRequests->where('payout_ref', 'like', '%'.$this->data['value'].'%')->orWhere('payout_id','like','%'.$this->data['value'].'%');
        endif;
        if($this->data['status'] !=null):
            $fundRequests = $fundRequests->where('status_id',$this->data['status']);
        endif;
        foreach($fundRequests->get() as $fundRequest):
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
