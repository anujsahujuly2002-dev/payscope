<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiPartner extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id',
        'added_by',
        'mobile_no',
        'address',
        'state_id',
        'city',
        'pincode',
        'shop_name',
        'pancard_no',
        'addhar_card',
        'scheme_id',
        'website',
    ];

    public function parentDetails() {
        return $this->belongsTo(User::class,'added_by','id');
    }
}
