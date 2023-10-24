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
        'type',
        'pay_date',
        'pay_slip',
        'references_no',
        'remark',
        'status_id',
    ];
}
