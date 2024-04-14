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
            $status='<span class="badge rounded-pill bg-danger" style="background-color:#FE0000;">Rejected</span>';
        elseif($value=='approved'):
            $status = '<span class="badge rounded-pill bg-success" style="background-color:#49FF00;">Success</span>';
        elseif($value=='refunded'):
            $status = '<span class="badge rounded-pill bg-success" style="background-color:#49FF00;">Success</span>';
        endif;
        return $status;
    }
}
