<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $table = "services_types";
    protected $guarded = false;


    public function templates()
    {
        return $this->hasMany(ServiceTemplate::class, 'services_types_id');
    }


    public function services()
    {
        return $this->hasMany(Service::class, 'services_types_id');
    }

}
