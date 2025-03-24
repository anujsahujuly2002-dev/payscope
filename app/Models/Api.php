<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'url',
        'username',
        'password',
        'optional',
        'code',
        'type',
    ];
}
