<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'order_id',
        'opening_amount',
        'order_amount',
        'closing_amount',
        'status_id',
        'razorpay_response',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
