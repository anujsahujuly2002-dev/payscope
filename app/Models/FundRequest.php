<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'account_number',
        'account_holder_name',
        'ifsc_code',
        'amount',
        'payment_mode_id',
        'status_id',
        'type',
        'pay_type',
        'payout_id',
        'payout_ref',
<<<<<<< HEAD
        'utr_number',
        'payment_type',
=======
>>>>>>> bde5cc6 (again setup)
    ];

    public function user () {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function status() {
        return $this->belongsTo(Status::class,'status_id','id');
    }

    public function payoutTransactionHistories() {
        return $this->hasOne(PayoutRequestHistory::class,'fund_request_id','id');
    }

    public function getCreatedAtAttribute($value){
<<<<<<< HEAD
        return date('d M y - h:i:s A', strtotime($value));
=======
        return date('d M y - h:i A', strtotime($value));
>>>>>>> bde5cc6 (again setup)
    }
}
