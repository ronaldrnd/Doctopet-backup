<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['appointment_id', 'specialist_id', 'user_id', 'rating', 'comment','status'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function specialist()
    {
        return $this->belongsTo(User::class, 'specialist_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
