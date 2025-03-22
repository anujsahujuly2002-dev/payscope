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
        'entity',
        'name',
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
        'close_reason'
    ];

    public function status() {
        return $this->belongsTo(Status::class,'status_id','id');
    }
}
