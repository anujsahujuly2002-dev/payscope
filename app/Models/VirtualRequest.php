<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'client_account_number',
        'payment_method',
        'opening_amount',
        'credit_amount',
        'closing_amount',
        'reference_number',
        'remitter_name',
        'remitter_account_number',
        'remitter_ifsc_code',
        'remitter_bank',
        'remitter_branch',
        'remitter_utr',
        'credit_account_number',
        'inward_refernce_number',
        'inward_refernce_number',
        'status_id',
        'credit_time',
    ];

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }


    public function status() {
        return $this->belongsTo(Status::class,'status_id','id');
    }

}
