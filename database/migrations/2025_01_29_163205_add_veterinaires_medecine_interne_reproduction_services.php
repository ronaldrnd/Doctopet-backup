<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Récupérer l'ID des services types "Médecine interne" et "Reproduction"
        $medecine_interne = DB::table('services_types')->where('libelle', 'Médecine interne')->first();
        $reproduction = DB::table('services_types')->where('libelle', 'Reproduction')->first();

        // Ajouter les services en médecine interne
        if ($medecine_interne) {
            DB::table('service_templates')->insert([
                [
                    'name' => 'Consultation pour troubles digestifs',
                    'description' => 'Évaluation des vomissements, diarrhées et autres troubles digestifs.',
                    'price' => 80.00,
                    'duration' => 45,
                    'gap_between_services' => 15,
                    'services_types_id' => $medecine_interne->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Tests pour maladies rénales ou hépatiques',
                    'description' => 'Analyses sanguines et urinaires pour diagnostiquer des pathologies rénales ou hépatiques.',
                    'price' => 100.00,
                    'duration' => 60,
                    'gap_between_services' => 20,
                    'services_types_id' => $medecine_interne->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Diagnostic et gestion du diabète',
                    'description' => 'Mise en place de traitements et suivi pour les animaux diabétiques.',
                    'price' => 120.00,
                    'duration' => 60,
                    'gap_between_services' => 20,
                    'services_types_id' => $medecine_interne->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Soins pour troubles thyroïdiens',
                    'description' => 'Diagnostic et suivi des troubles hormonaux comme l\'hypothyroïdie et l\'hyperthyroïdie.',
                    'price' => 100.00,
                    'duration' => 45,
                    'gap_between_services' => 15,
                    'services_types_id' => $medecine_interne->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        // Ajouter les services en reproduction
        if ($reproduction) {
            DB::table('service_templates')->insert([
                [
                    'name' => 'Insémination artificielle',
                    'description' => 'Procédure d\'insémination artificielle pour assurer une reproduction contrôlée.',
                    'price' => 150.00,
                    'duration' => 90,
                    'gap_between_services' => 30,
                    'services_types_id' => $reproduction->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Suivi de la gestation',
                    'description' => 'Échographies et radiographies pour surveiller la gestation des animaux.',
                    'price' => 120.00,
                    'duration' => 60,
                    'gap_between_services' => 20,
                    'services_types_id' => $reproduction->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Assistance à l’accouchement',
                    'description' => 'Surveillance et assistance pour un accouchement naturel ou une césarienne.',
                    'price' => 300.00,
                    'duration' => 180,
                    'gap_between_services' => 60,
                    'services_types_id' => $reproduction->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Suivi post-natal',
                    'description' => 'Contrôle de la mère et des petits après l’accouchement.',
                    'price' => 80.00,
                    'duration' => 45,
                    'gap_between_services' => 15,
                    'services_types_id' => $reproduction->id,
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
            'Consultation pour troubles digestifs',
            'Tests pour maladies rénales ou hépatiques',
            'Diagnostic et gestion du diabète',
            'Soins pour troubles thyroïdiens',
            'Insémination artificielle',
            'Suivi de la gestation',
            'Assistance à l’accouchement',
            'Suivi post-natal',
        ])->delete();
    }
};

