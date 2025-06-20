<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use HaversineFormula;

class VetoExt extends Model
{
    use HasFactory;
    protected $table = 'veto_ext';
    protected $fillable = ['name'];

    public function cabinets()
    {
        return $this->belongsToMany(Cabinet::class, 'spe_has_cabinet', 'veto_ext_id', 'cabinet_id');
    }


    public function specialites()
    {
        return $this->belongsToMany(Specialite::class, 'veto_ext_specialite');
    }

    public static function findNearby($latitude, $longitude, $specialiteId, $maxDistance = 50)
    {
        return self::whereHas('cabinets', function ($query) use ($latitude, $longitude, $maxDistance) {
            $query->selectRaw(
                "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance",
                [$latitude, $longitude, $latitude]
            )
                ->having("distance", "<=", $maxDistance)
                ->orderBy("distance");
        })
            ->whereHas('specialites', function ($query) use ($specialiteId) {
                $query->where('specialites.id', $specialiteId); // 👉 Ajout de l'alias 'specialites.id' pour éviter l’ambiguïté
            })
            ->get();
    }



}
