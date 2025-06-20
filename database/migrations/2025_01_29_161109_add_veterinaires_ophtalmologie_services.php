<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Récupérer l'ID du service type "Ophtalmologie"
        $serviceType = DB::table('services_types')->where('libelle', 'Ophtalmologie')->first();

        if ($serviceType) {
            DB::table('service_templates')->insert([
                [
                    'name' => 'Diagnostic des maladies des yeux',
                    'description' => 'Consultation spécialisée pour détecter des pathologies comme les ulcères cornéens ou les glaucomes.',
                    'price' => 70.00,
                    'duration' => 40,
                    'gap_between_services' => 15,
                    'services_types_id' => $serviceType->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Contrôle de la vision et tests spécifiques',
                    'description' => 'Examen approfondi de la vision de l\'animal avec tests spécialisés.',
                    'price' => 50.00,
                    'duration' => 30,
                    'gap_between_services' => 10,
                    'services_types_id' => $serviceType->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Chirurgie des paupières (entropion, ectropion)',
                    'description' => 'Intervention chirurgicale pour corriger les anomalies des paupières.',
                    'price' => 250.00,
                    'duration' => 90,
                    'gap_between_services' => 30,
                    'services_types_id' => $serviceType->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Ablation de cataractes',
                    'description' => 'Opération chirurgicale pour retirer la cataracte et améliorer la vision.',
                    'price' => 600.00,
                    'duration' => 120,
                    'gap_between_services' => 45,
                    'services_types_id' => $serviceType->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Correction des ulcères cornéens',
                    'description' => 'Traitement chirurgical ou médicamenteux pour soigner les ulcères de la cornée.',
                    'price' => 150.00,
                    'duration' => 60,
                    'gap_between_services' => 20,
                    'services_types_id' => $serviceType->id,
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
            'Diagnostic des maladies des yeux',
            'Contrôle de la vision et tests spécifiques',
            'Chirurgie des paupières (entropion, ectropion)',
            'Ablation de cataractes',
            'Correction des ulcères cornéens',
        ])->delete();
    }
};
