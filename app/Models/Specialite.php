<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public function serviceTemplates()
    {
        return $this->belongsToMany(
            ServiceTemplate::class,
            'specialite_services_types',
            'specialite_id',
            'services_types_id'
        );
    }
}
