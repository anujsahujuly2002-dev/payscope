<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessfulPaymentCollection extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'payment_id',
        'order_amount',
        'amount',
        'charges',
        'gst',
        'settelment_id'
    ];
}
