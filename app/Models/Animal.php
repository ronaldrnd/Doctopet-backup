<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;
    protected $table = 'animaux';
    protected $guarded = false;


    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }

    public function dossiers()
    {
        return $this->hasMany(DossierMedical::class);
    }


    public function espece()
    {
        return $this->belongsTo(Espece::class);
    }

    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    public function getPhotoAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }


    public function vaccins()
    {
        return $this->hasMany(AnimalVaccine::class, 'animal_id');
    }

    public function medicalHistories()
    {
        return $this->hasMany(AnimalMedicalHistory::class);
    }

}
