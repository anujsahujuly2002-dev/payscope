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
        'company_name',
        'company_gst_number',
        'company_cin_number',
        'company_pan',
        'razorpay_customer_id'
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

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
