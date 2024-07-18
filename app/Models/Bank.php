<?php

namespace App\Models;

use App\Models\Fund;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bank extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'name',
        'account_number',
        'ifsc_code',
        'branch_name',
        'status'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function funds()
    {
        return $this->hasMany(Fund::class);
    }
    }

