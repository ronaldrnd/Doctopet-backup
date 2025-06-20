<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeHasCabinet extends Model
{
    use HasFactory;
    protected $table = 'spe_has_cabinet';
    protected $fillable = ['cabinet_id', 'veto_ext_id'];



}
