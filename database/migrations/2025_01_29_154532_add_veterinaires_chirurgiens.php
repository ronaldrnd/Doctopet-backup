<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Récupération des IDs des services_types en fonction du libellé
        $servicesTypes = DB::table('services_types')->pluck('id', 'libelle');

        DB::table('service_templates')->insert([
            // **CHIRURGIES SPÉCIFIQUES**
            [
                'name' => 'Extraction de tumeurs',
                'description' => 'Chirurgie pour retirer des masses tumorales chez les animaux, nécessitant une analyse en laboratoire.',
                'price' => 250.00,
                'duration' => 90,
                'gap_between_services' => 30,
                'services_types_id' => $servicesTypes['Chirurgie']
            ],
            [
                'name' => 'Chirurgies orthopédiques (fractures, luxations)',
                'description' => 'Réparation des os fracturés, stabilisation des luxations et pose de matériel orthopédique.',
                'price' => 500.00,
                'duration' => 180,
                'gap_between_services' => 60,
                'services_types_id' => $servicesTypes['Orthopédie']
            ],
            [
                'name' => 'Détartrage avancé sous anesthésie',
                'description' => 'Détartrage approfondi des dents sous anesthésie pour prévenir les infections et maladies parodontales.',
                'price' => 120.00,
                'duration' => 75,
                'gap_between_services' => 20,
                'services_types_id' => $servicesTypes['Dentisterie']
            ]
        ]);
    }

    public function down(): void
    {
        DB::table('service_templates')->whereIn('name', [
            'Extraction de tumeurs',
            'Chirurgies orthopédiques (fractures, luxations)',
            'Détartrage avancé sous anesthésie'
        ])->delete();
    }
};
