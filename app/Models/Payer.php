<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'limit_per_transaction',
        'limit_total',
        'limit_consumed',
        'limit_available',
        'limit_increase_offer',
        'allow_profile_update',
        'maximum_daily_limit',
        'consumed_daily_limit',
        'available_daily_limit',
        'maximum_monthly_limit',
        'consumed_monthly_limit',
        'available_monthly_limit',
    ];
}
