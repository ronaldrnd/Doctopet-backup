<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogStock extends Model
{
    use HasFactory;
    protected $table = 'log_stocks';
    protected $guarded = false;


    /**
     * Relation avec l'utilisateur qui a effectué l'action.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'actif concerné par le log.
     */
    public function actif()
    {
        return $this->belongsTo(Actif::class);
    }
}
