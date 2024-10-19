<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'transaction_id',
        'opening_balance',
        'amount',
        'closing_balnce',
        'transaction_type',
    ];
}
