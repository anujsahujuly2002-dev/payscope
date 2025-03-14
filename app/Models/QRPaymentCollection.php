<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRPaymentCollection extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'qr_code_id',
        'order_id',
        'entity',
        'name',
        'email',
        'mobile_no',
        'usage',
        'type',
        'image_url',
        'payment_amount',
        'qr_status',
        'description',
        'fixed_amount',
        'payments_amount_received',
        'payments_count_received',
        'qr_close_at',
        'qr_created_at',
        'status_id',
        'close_by',
        'is_payment_settel',
        'close_reason',
        'payer_name',
        'utr_number',
        'payment_id',
        'charge',
        'gst',
        'payment_type',
        'payment_channel'
    ];

    public function status() {
        return $this->belongsTo(Status::class,'status_id','id');
    }
    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
