<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierMedical extends Model
{
    use HasFactory;
    protected $table = 'dossiers_medicaux';
    protected $guarded = false;


    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function veterinaire()
    {
        return $this->belongsTo(User::class, 'veterinaire_id');
    }



}
