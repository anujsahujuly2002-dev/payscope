<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    public function getNameAttribute($value){
        if($value =='pending'):
            $status = '<span class="badge rounded-pill bg-warning">Pending</span>';
        elseif($value=='rejected'):
            $status='<span class="badge rounded-pill bg-danger">Rejected</span>';
        elseif($value=='approved'):
            $status = '<span class="badge rounded-pill bg-success">Success</span>';
        endif;
        return $status;
    }
}
