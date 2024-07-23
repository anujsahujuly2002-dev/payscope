<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ApiPartnerExport implements FromCollection,WithHeadings
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
        $apiPartnerArray = [];
        $partner = new User;
        if($this->data['user_id'] !=null):
            $partner = $partner->where('user_id',$this->data['user_id']);
        endif;
        if($this->data['start_date'] !=null && $this->data['end_date'] ==null):
            $partner = $partner->whereDate('created_at',$this->data['start_date']);
        endif;
        if($this->data['start_date'] !=null && $this->data['end_date'] !=null):
            $partner = $partner->whereDate('created_at','>=',$this->data['start_date'])->whereDate("created_at","<=",$this->data['end_date']);
        endif;
        if($this->data['value'] !=null):
            $partner = $partner->where('mobile_no','like','%'.$this->data['value'].'%')
             ->orWhere('address','like','%'.$this->data['value'].'%')
             ->orWhere('state','like','%'.$this->data['value'].'%')
             ->orWhere('city','like','%'.$this->data['value'].'%')
             ->orWhere('pincode','like','%'.$this->data['value'].'%')
             ->orWhere('shop_name','like','%'.$this->data['value'].'%')
             ->orWhere('pancard_number','like','%'.$this->data['value'].'%')
             ->orWhere('adhaarcard_number','like','%'.$this->data['value'].'%');
        endif;
        // if($this->data['status'] !=null):
        //     $partner = $partner->where('status_id',$this->data['status']);
        // endif;


        foreach($partner->get() as $partners):
            $partnerArray[]=[
                $partners->name,
                $partners->mobile_no,
                ucfirst($partners->getRoleNames()->first()),
                $partners->apiPartner?->shop_name,
                $partners->walletAmount?->amount,
                $partners->walletAmount?->locked_amuont,
                $partners->status,
            //  strip_tags($partners->status?->name),
                Carbon::parse( $partners->apiPartnerHistories?->created_at)->format('dS M Y'),
            ];
        endforeach;

        return collect($partnerArray);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function headings(): array
    {
        return ['Name', 'Mobile No.','Role','Company','Wallet Amount','Locked Amount','Status','Date'];
    }


    }

