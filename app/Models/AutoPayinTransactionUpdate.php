<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoPayinTransactionUpdate extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'qr_collection_id',
        'webhook_url'
    ];
}
