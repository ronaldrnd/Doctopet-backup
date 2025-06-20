<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Espece extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function races()
    {
        return $this->hasMany(Race::class);
    }

    public function animaux()
    {
        return $this->hasMany(Animal::class);
    }
}
