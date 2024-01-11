<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorManager extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'operator_type',
        'api_id',
        'status',
    ];

    public function api() {
        return $this->belongsTo(Api::class,'api_id','id');
    }
}
