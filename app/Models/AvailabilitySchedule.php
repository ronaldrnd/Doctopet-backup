<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailabilitySchedule extends Model
{
    public $timestamps = false;
    protected $table = 'availability_schedule';
    protected $guarded = false;
}
