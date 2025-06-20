<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        DB::transaction(function () {
            // 🔄 Fusionner "Oiseaux" dans "Oiseau"
            $oldSpecies = DB::table('especes')->where('nom', 'Oiseaux')->first();
            $newSpecies = DB::table('especes')->where('nom', 'Oiseau')->first();

            if ($oldSpecies && $newSpecies) {
                // Déplacer toutes les races de "Oiseaux" vers "Oiseau"
                DB::table('races')
                    ->where('espece_id', $oldSpecies->id)
                    ->update(['espece_id' => $newSpecies->id]);

                // Supprimer l'ancienne espèce "Oiseaux"
                DB::table('especes')->where('id', $oldSpecies->id)->delete();
            }

            // 🚮 Suppression des espèces et leurs races associées
            $speciesToDelete = ['Hérissons', 'Furets', 'Insectes & Arachnides', 'Amphibiens'];

            $speciesIds = DB::table('especes')
                ->whereIn('nom', $speciesToDelete)
                ->pluck('id');

            if ($speciesIds->isNotEmpty()) {
                // Supprimer les races liées
                DB::table('races')->whereIn('espece_id', $speciesIds)->delete();

                // Supprimer les espèces
                DB::table('especes')->whereIn('id', $speciesIds)->delete();
            }
        });
    }

    public function down()
    {
        // 🚨 Impossible de restaurer les espèces supprimées automatiquement
        throw new Exception("Cette migration ne peut pas être annulée automatiquement.");
    }
};
