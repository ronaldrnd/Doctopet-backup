<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elevage extends Model
{
    use HasFactory;

    protected $fillable = [
        'espece_id', 'race_id', 'age', 'taille', 'stock', 'eleveur_id'
    ];

    public function espece()
    {
        return $this->belongsTo(Espece::class);
    }

    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    public function eleveur()
    {
        return $this->belongsTo(User::class, 'eleveur_id');
    }
}
