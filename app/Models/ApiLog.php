<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'url',
        'txn_id',
        'header',
        'request',
        'response',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
