<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TriggerStock extends Model
{
    use HasFactory;


    protected $table = "triggers_stock";

    protected $fillable = [
        'actif_id', 'fournisseur_id', 'user_id', 'montant', 'ask_montant', 'is_enable', 'trigger_method'
    ];


    public function actif()
    {
        return $this->belongsTo(Actif::class);
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
