<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RazorapEventHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'event',
        'payment_channel',
        'response',
    ];
}
