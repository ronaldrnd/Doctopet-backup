<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Récupérer l'ID des services types "Orthopédie", "Comportemental" et "Soins palliatifs"
        $orthopedie = DB::table('services_types')->where('libelle', 'Orthopédie')->first();
        $comportemental = DB::table('services_types')->where('libelle', 'Comportemental')->first();
        $soins_palliatifs = DB::table('services_types')->where('libelle', 'Soins palliatifs')->first();

        // Ajouter les services en orthopédie
        if ($orthopedie) {
            DB::table('service_templates')->insert([
                [
                    'name' => 'Consultation pour boiteries ou douleurs articulaires',
                    'description' => 'Évaluation des troubles de la marche et des douleurs articulaires.',
                    'price' => 90.00,
                    'duration' => 45,
                    'gap_between_services' => 15,
                    'services_types_id' => $orthopedie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Tests spécifiques (hanches, genoux, coudes)',
                    'description' => 'Examens approfondis pour diagnostiquer les pathologies orthopédiques.',
                    'price' => 110.00,
                    'duration' => 60,
                    'gap_between_services' => 20,
                    'services_types_id' => $orthopedie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Réparation de fractures',
                    'description' => 'Intervention chirurgicale pour consolidation osseuse après fracture.',
                    'price' => 500.00,
                    'duration' => 180,
                    'gap_between_services' => 60,
                    'services_types_id' => $orthopedie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Pose de prothèses (hanche, genou)',
                    'description' => 'Chirurgie spécialisée pour implantation de prothèses articulaires.',
                    'price' => 1500.00,
                    'duration' => 240,
                    'gap_between_services' => 90,
                    'services_types_id' => $orthopedie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Ostéotomie corrective',
                    'description' => 'Réalignement des membres pour corriger les malformations osseuses.',
                    'price' => 1000.00,
                    'duration' => 240,
                    'gap_between_services' => 90,
                    'services_types_id' => $orthopedie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        // Ajouter les services en comportement animal
        if ($comportemental) {
            DB::table('service_templates')->insert([
                [
                    'name' => 'Consultation pour troubles comportementaux',
                    'description' => 'Analyse des troubles comportementaux tels que l’anxiété ou l’agressivité.',
                    'price' => 80.00,
                    'duration' => 60,
                    'gap_between_services' => 15,
                    'services_types_id' => $comportemental->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Mise en place de thérapies comportementales',
                    'description' => 'Traitement personnalisé pour améliorer le comportement de l’animal.',
                    'price' => 100.00,
                    'duration' => 60,
                    'gap_between_services' => 20,
                    'services_types_id' => $comportemental->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Suivi avec éducateur canin',
                    'description' => 'Travail en collaboration avec un éducateur canin pour une meilleure prise en charge.',
                    'price' => 70.00,
                    'duration' => 45,
                    'gap_between_services' => 15,
                    'services_types_id' => $comportemental->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        // Ajouter les services en soins palliatifs
        if ($soins_palliatifs) {
            DB::table('service_templates')->insert([
                [
                    'name' => 'Gestion de la douleur pour maladies chroniques',
                    'description' => 'Traitement de la douleur pour améliorer le confort de l’animal en fin de vie.',
                    'price' => 90.00,
                    'duration' => 45,
                    'gap_between_services' => 15,
                    'services_types_id' => $soins_palliatifs->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Suivi des animaux en fin de vie',
                    'description' => 'Accompagnement et soins pour améliorer la qualité de vie de l’animal en fin de vie.',
                    'price' => 100.00,
                    'duration' => 60,
                    'gap_between_services' => 20,
                    'services_types_id' => $soins_palliatifs->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Assistance à domicile pour fin de vie',
                    'description' => 'Soins et accompagnement à domicile pour assurer une transition paisible.',
                    'price' => 120.00,
                    'duration' => 90,
                    'gap_between_services' => 30,
                    'services_types_id' => $soins_palliatifs->id,
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
            'Consultation pour boiteries ou douleurs articulaires',
            'Tests spécifiques (hanches, genoux, coudes)',
            'Réparation de fractures',
            'Pose de prothèses (hanche, genou)',
            'Ostéotomie corrective',
            'Consultation pour troubles comportementaux',
            'Mise en place de thérapies comportementales',
            'Suivi avec éducateur canin',
            'Gestion de la douleur pour maladies chroniques',
            'Suivi des animaux en fin de vie',
            'Assistance à domicile pour fin de vie',
        ])->delete();
    }
};
