<?php

namespace App\Models;

use App\Services\StockTriggerService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stocks';
    protected $guarded = false;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'actif (médicament ou autre).
     */
    public function actif()
    {
        return $this->belongsTo(Actif::class);
    }


    public static function boot()
    {
        parent::boot();

        static::updated(function (Stock $stock) {
            $stock->checkTrigger();
        });


    }


    public function checkTrigger()
    {
        $trigger = TriggerStock::where('actif_id', $this->actif_id)
            ->where('user_id', $this->user_id)
            ->first();

        // Vérifier si le déclencheur et le stock existent
        if ($trigger && is_numeric($this->stock) && is_numeric($trigger->montant)) {
            if ((int)$this->stock <= (int)$trigger->montant) {
                StockTriggerService::checkStockLevels();
            }
        }
    }

}
