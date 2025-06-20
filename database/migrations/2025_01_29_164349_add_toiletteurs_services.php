<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Récupérer l'ID du service type "Toilettage"
        $toilettage = DB::table('services_types')->where('libelle', 'Toilettage')->first();

        if ($toilettage) {
            DB::table('service_templates')->insert([
                // 🛁 Soins de base
                [
                    'name' => 'Bain',
                    'description' => 'Toilette complète avec un shampoing adapté à l\'animal.',
                    'price' => 30.00,
                    'duration' => 30,
                    'gap_between_services' => 15,
                    'services_types_id' => $toilettage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Shampoing',
                    'description' => 'Nettoyage approfondi avec un shampoing hydratant ou hypoallergénique.',
                    'price' => 25.00,
                    'duration' => 30,
                    'gap_between_services' => 15,
                    'services_types_id' => $toilettage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Shampoing antiparasitaire',
                    'description' => 'Bain spécial pour éliminer les puces et tiques.',
                    'price' => 35.00,
                    'duration' => 40,
                    'gap_between_services' => 20,
                    'services_types_id' => $toilettage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                // ✨ Entretien esthétique
                [
                    'name' => 'Démêlage',
                    'description' => 'Brossage et démêlage du pelage pour éviter les nœuds.',
                    'price' => 20.00,
                    'duration' => 30,
                    'gap_between_services' => 10,
                    'services_types_id' => $toilettage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Brushing',
                    'description' => 'Séchage et coiffage pour un pelage soyeux et bien structuré.',
                    'price' => 30.00,
                    'duration' => 40,
                    'gap_between_services' => 15,
                    'services_types_id' => $toilettage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Brossage/Débourrage',
                    'description' => 'Élimination des poils morts pour un pelage sain.',
                    'price' => 25.00,
                    'duration' => 30,
                    'gap_between_services' => 10,
                    'services_types_id' => $toilettage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                // ✂️ Coupe et tonte
                [
                    'name' => 'Coupe ciseau',
                    'description' => 'Coupe artisanale au ciseau pour un rendu naturel.',
                    'price' => 50.00,
                    'duration' => 60,
                    'gap_between_services' => 15,
                    'services_types_id' => $toilettage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Coupe mouton',
                    'description' => 'Toilettage spécial pour les chiens à poils longs et denses.',
                    'price' => 55.00,
                    'duration' => 60,
                    'gap_between_services' => 15,
                    'services_types_id' => $toilettage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Tondeuse',
                    'description' => 'Tonte complète pour un entretien facile du pelage.',
                    'price' => 40.00,
                    'duration' => 50,
                    'gap_between_services' => 15,
                    'services_types_id' => $toilettage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                // 🩺 Soins spécifiques
                [
                    'name' => 'Coupe des griffes',
                    'description' => 'Coupe précise des griffes pour éviter les blessures.',
                    'price' => 15.00,
                    'duration' => 15,
                    'gap_between_services' => 5,
                    'services_types_id' => $toilettage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Tour des pattes',
                    'description' => 'Entretien et coupe autour des pattes pour une hygiène parfaite.',
                    'price' => 20.00,
                    'duration' => 20,
                    'gap_between_services' => 10,
                    'services_types_id' => $toilettage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Épilation',
                    'description' => 'Élimination des poils morts pour races nécessitant un épilage régulier.',
                    'price' => 35.00,
                    'duration' => 40,
                    'gap_between_services' => 15,
                    'services_types_id' => $toilettage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Vidange des glandes anales',
                    'description' => 'Service d\'hygiène pour prévenir les infections.',
                    'price' => 25.00,
                    'duration' => 15,
                    'gap_between_services' => 5,
                    'services_types_id' => $toilettage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                // 🧼 Hygiène et nettoyage
                [
                    'name' => 'Nettoyage de la bouche',
                    'description' => 'Hygiène buccale pour prévenir les maladies dentaires.',
                    'price' => 30.00,
                    'duration' => 20,
                    'gap_between_services' => 10,
                    'services_types_id' => $toilettage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Nettoyage des yeux et oreilles',
                    'description' => 'Soins pour éviter infections et inflammations.',
                    'price' => 20.00,
                    'duration' => 20,
                    'gap_between_services' => 10,
                    'services_types_id' => $toilettage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Insectifuge',
                    'description' => 'Traitement pour éloigner les parasites externes (puces, tiques).',
                    'price' => 35.00,
                    'duration' => 30,
                    'gap_between_services' => 15,
                    'services_types_id' => $toilettage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('service_templates')->whereIn('name', [
            'Bain',
            'Shampoing',
            'Shampoing antiparasitaire',
            'Démêlage',
            'Brushing',
            'Brossage/Débourrage',
            'Coupe ciseau',
            'Coupe mouton',
            'Tondeuse',
            'Coupe des griffes',
            'Tour des pattes',
            'Épilation',
            'Vidange des glandes anales',
            'Nettoyage de la bouche',
            'Nettoyage des yeux et oreilles',
            'Insectifuge',
        ])->delete();
    }
};
