<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'espece_id'];

    public function espece()
    {
        return $this->belongsTo(Espece::class);
    }
}
