<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actif extends Model
{
    protected $table = 'actifs';
    protected $guarded = [];


    /**
     * Relation avec le stock de l'utilisateur.
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * Relation avec les logs de stock.
     */
    public function logStocks()
    {
        return $this->hasMany(LogStock::class);
    }

}
