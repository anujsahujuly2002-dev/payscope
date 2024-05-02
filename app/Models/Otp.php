<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;
    protected $fillable =[
        "user_id",
        "verified_at",
        "verified_at",
        "otp",
        "expire_at",
    ];
}
