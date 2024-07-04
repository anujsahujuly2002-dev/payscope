<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','api_id','status'
    ];

    public function api() {
        return $this->belongsTo(Api::class,'api_id','id');
    }
}
