<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecializedService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'name',
        'price',
        'duration',
        'size',
        'min_weight',
        'max_weight',
        'min_height',
        'max_height',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
