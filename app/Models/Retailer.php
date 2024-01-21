<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    use HasFactory;
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
