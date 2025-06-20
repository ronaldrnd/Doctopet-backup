<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalVaccine extends Model
{
    public $table = 'animal_vaccines';
    public $guarded = false;


    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    public function specialist()
    {
        return $this->belongsTo(User::class, 'added_by_specialist_id');
    }


}
