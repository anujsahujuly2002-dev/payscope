<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'bank_id',
        'payment_mode_id',
        'credited_by',
        'amount',
        'opening_amount',
        'closing_amount',
        'type',
        'pay_date',
        'pay_slip',
        'references_no',
        'remark',
        'status_id',
    ];

    public function bank() {
        return $this->belongsTo(Bank::class,'bank_id','id');
    }

    public function paymentMode(){
        return $this->belongsTo(PaymentMode::class,'payment_mode_id','id');
    }

    public function status() {
        return $this->belongsTo(Status::class,'status_id','id');
    }

    public function user () {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
