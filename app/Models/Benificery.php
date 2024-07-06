<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benificery extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'account_number',
        'ifcs_code',
        'listed_id',
        'type',
        'added_by',
    ];
}
