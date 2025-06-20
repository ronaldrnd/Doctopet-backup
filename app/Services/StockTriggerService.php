<?php

namespace App\Services;

use App\Models\TriggerStock;
use App\Models\Stock;
use Illuminate\Support\Facades\Mail;
use App\Mail\StockOrderNotification;

class StockTriggerService
{
    public static function checkStockLevels()
    {
        $triggers = TriggerStock::where('is_enable', true)->get();

        foreach ($triggers as $trigger) {
            $stock = Stock::where('user_id', $trigger->user_id)
                ->where('actif_id', $trigger->actif_id)
                ->first();

            if ($stock && $stock->stock <= $trigger->montant) {
                if ($trigger->trigger_method === 'automatic') {
                    static::sendStockAlert($trigger);
                } else {
                    session()->flash('message', "⚠️ Le stock de {$trigger->actif->nom} est bas. Pensez à commander !");
                }
            }
        }
    }

    private static function sendStockAlert(TriggerStock $trigger)
    {
        Mail::to($trigger->fournisseur->email_adress)->send(new StockOrderNotification($trigger));
    }
}
