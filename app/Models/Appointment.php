<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'user_id',
        'animal_id',
        'specialized_service_id',
        'date',
        'start_time',
        'end_time',
        'message',
        'status',
        'comment',
        'assign_specialist_id'
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            $appointment->confirmation_token = \Str::random(40);
            $appointment->token_used = false;
        });
    }


    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function specializedService()
    {
        return $this->belongsTo(SpecializedService::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }


    public function assignedSpecialist()
    {
        return $this->belongsTo(User::class, 'assign_specialist_id');
    }


}
