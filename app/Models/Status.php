<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public function getNameAttribute($value){
        $status = '';
        if($value =='pending'):
            $status = '<span class="badge rounded-pill" style="background-color:#FF8E00">Pending</span>';
        elseif($value=='rejected'):
            $status='<span class="badge rounded-pill" style="background-color:#FE0000;">Rejected</span>';
        elseif($value=='approved'):
            $status = '<span class="badge rounded-pill" style="background-color:#49FF00;">Success</span>';
        elseif($value=='refunded'):
            $status = '<span class="badge rounded-pill" style="background-color:#1C1678;">Refunded</span>';
        endif;
        return $status;
    }


    // public function statusApi($value)
    // {
    //     if ($value == 'pending') {
    //         return 'Pending';
    //     } elseif ($value == 'rejected') {
    //         return 'Rejected';
    //     } elseif ($value == 'approved') {
    //         return 'Success';
    //     } elseif ($value == 'refunded') {
    //         return 'Refunded';
    //     }
    //     return $value;
    // }
}
