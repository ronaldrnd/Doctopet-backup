<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTemplate extends Model
{
    use HasFactory;



    protected $table = 'service_templates';
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'gap_between_services',
        'services_types_id',
    ];



    public function specialities()
    {
        return $this->belongsToMany(
            Specialite::class,                         // Modèle lié
            'specialite_services_types',               // Table pivot
            'services_types_id',                       // Clé étrangère dans la table pivot pour ServiceTemplate
            'specialite_id'                            // Clé étrangère dans la table pivot pour Specialite
        );
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class, 'services_types_id');
    }



}
