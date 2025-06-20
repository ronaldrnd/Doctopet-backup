<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;
    protected $table = 'fournisseurs';
    protected $guarded = false;

    /**
     * Relation avec l'utilisateur (propriétaire du fournisseur).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
