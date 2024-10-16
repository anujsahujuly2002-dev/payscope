<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiToken extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id',
        'ip_address',
        'domain',
        'token',
        'payin_webhook_url'
    ];

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
