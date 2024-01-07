<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginSession extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'latitude',
        'logitude',
        'ip_address',
        'login_time',
        'is_logged_in',
        'logout_time',
    ];
}
