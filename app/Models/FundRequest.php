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
    ];
}
