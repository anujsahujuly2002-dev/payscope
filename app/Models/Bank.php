<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
