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
        'brand_name',
        'company_state_name',
        'company_city',
        'company_pincode',
        'company_pan',
        'company_adhaarcard',
        'gst',
        'cin_number',
        'email',
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
