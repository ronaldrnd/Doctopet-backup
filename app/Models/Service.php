<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'duration',
        'animals_supported',
        'gap_between_services',
        'services_types_id',
        'is_enabled'
    ];

    protected $casts = [
        'animals_supported' => 'array',
    ];

    public function schedules() {
        return $this->hasMany(ServiceSchedule::class);
    }

    public function specializedServices()
    {
        return $this->hasMany(SpecializedService::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }



    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class, 'services_types_id');
    }

    public function template()
    {
        return $this->belongsTo(ServiceTemplate::class, 'services_types_id', 'services_types_id');
    }



    public function excludedSpecies()
    {
        return $this->belongsToMany(Espece::class, 'service_excluded_species');
    }

}
