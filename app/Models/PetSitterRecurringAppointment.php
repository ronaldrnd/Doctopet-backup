<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetSitterRecurringAppointment extends Model
{
    use HasFactory;
    protected $table = 'pet_sitter_recurring_appointments';
    protected $guarded = false;
}
