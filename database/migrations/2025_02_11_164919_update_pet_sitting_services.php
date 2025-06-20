<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Renommer "Pet-sitting" en "Hébergement"
        DB
            ::table('services_types')
            ->where('libelle', 'Pet-sitting')
            ->update(['libelle' => 'Hébergement', 'color_tag' => '#3498DB']); // Changer la couleur si besoin

        // Ajouter "Garde à domicile"
        DB::table('services_types')->insert([
            'libelle' => 'Garde à domicile',
            'color_tag' => '#1ABC9C',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $petSitterSpecialite = DB::table('specialites')->where('nom', 'Pet-sitter')->first();

        if ($petSitterSpecialite) {
            $hebergementService = DB::table('services_types')->where('libelle', 'Hébergement')->first();
            $gardeDomicileService = DB::table('services_types')->where('libelle', 'Garde à domicile')->first();

            DB::table('specialite_services_types')->insert([
                [
                    'specialite_id' => $petSitterSpecialite->id,
                    'services_types_id' => $hebergementService->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'specialite_id' => $petSitterSpecialite->id,
                    'services_types_id' => $gardeDomicileService->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

    }

    public function down(): void
    {
        // Inverser les changements
        DB::table('services_types')
            ->where('libelle', 'Hébergement')
            ->update(['libelle' => 'Pet-sitting', 'color_tag' => '#F39C12']);

        DB::table('services_types')
            ->where('libelle', 'Garde à domicile')
            ->delete();
    }
};
