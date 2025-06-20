<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $table = "service_requests";
    protected $fillable = [
        'user_id', 'requested_name', 'description', 'suggested_price', 'suggested_duration', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


