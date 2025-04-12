<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;
    protected $fillable = [
        'scheme_id',
        'slab_id',
        'operator',
        'type',
        'gst',
        'value',
    ];
}
