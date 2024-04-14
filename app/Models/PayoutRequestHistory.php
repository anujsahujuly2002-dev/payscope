<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutRequestHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'api_id',
        'fund_request_id',
        'api_id',
        'amount',
        'charge',
        'closing_balnce',
        'status_id',
        'credited_by',
        'balance',
        'type',
        'transtype',
        'product',
        'remarks',
    ];
}
