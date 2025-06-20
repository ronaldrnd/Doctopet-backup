<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    protected $table = 'user_reports';
    protected $guarded = false;

    public function specialist()
    {
        return $this->hasOne(User::class,'id','specialist_id');
    }

    public function userTarget()
    {
        return $this->hasOne(User::class,'id','user_id_target');
    }


}
