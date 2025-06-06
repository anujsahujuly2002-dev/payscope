<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoTransactionUpdateWebhookModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'transaction_id',
        'webhook_url',
    ];
}
