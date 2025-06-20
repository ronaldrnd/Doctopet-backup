<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Récupérer tous les animaux sans race définie
        $animauxSansRace = DB::table('animaux')
            ->whereNull('race_id')
            ->get();

        foreach ($animauxSansRace as $animal) {
            // Récupérer la première race associée à l'espèce de l'animal
            $race = DB::table('races')
                ->where('espece_id', $animal->espece_id)
                ->orderBy('id', 'asc')
                ->first();

            if ($race) {
                // Mettre à jour l'animal avec la première race trouvée
                DB::table('animaux')
                    ->where('id', $animal->id)
                    ->update(['race_id' => $race->id]);
            }
        }
    }

    public function down()
    {
        
    }
};
