<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorManager extends Model
{
    use HasFactory;
    public $appends = ['charge_range','service_type'];
    protected $fillable = [
        'name',
        'operator_type',
        'api_id',
        'charge_range_start',
        'charge_range_end',
        'status',
    ];

    public function api() {
        return $this->belongsTo(Api::class,'api_id','id');
    }

    public function getChargeRangeAttribute() {
        return $this->charge_range_start."-".$this->charge_range_end;

    }

    public function getServiceTypeAttribute() {
        return $this->operator_type;
    }
}
