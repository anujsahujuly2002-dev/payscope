<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'dispute_id',
        'payment_id',
        'entity',
        'amount',
        'currency',
        'amount_deducted',
        'gateway_dispute_id',
        'reason_code',
        'respond_by',
        'status',
        'phase',
        'comments',
        'created_at_razorpay',
    ];

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function getCreatedAtRazorPayAttribute($value) {
        return date('d M y - H:i:s', strtotime($value));
    }

    public function getRespondByAttribute($value) {
        return date('F dS Y', strtotime($value));
    }
}
