<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalAppointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'client_name',
        'animal_name',
        'animal_espece',
        'animal_race',
        'date',
        'start_time',
        'end_time',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}
