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

    public function state(){
        return $this->belongsTo(State::class,'state_id','id');
    }
    public function scheme() {
        return $this->belongsTo(Scheme::class,'scheme_id','id');
    }
}
