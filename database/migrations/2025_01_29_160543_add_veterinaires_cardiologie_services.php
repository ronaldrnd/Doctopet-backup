<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Récupérer l'ID du service type "Cardiologie"
        $serviceType = DB::table('services_types')->where('libelle', 'Cardiologie')->first();

        if ($serviceType) {
            DB::table('service_templates')->insert([
                [
                    'name' => 'Électrocardiogramme (ECG)',
                    'description' => 'Examen permettant d\'analyser l\'activité électrique du cœur de votre animal.',
                    'price' => 60.00,
                    'duration' => 30,
                    'gap_between_services' => 15,
                    'services_types_id' => $serviceType->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Échographie cardiaque (doppler)',
                    'description' => 'Évaluation des structures cardiaques et du flux sanguin à l\'aide d\'ultrasons.',
                    'price' => 100.00,
                    'duration' => 45,
                    'gap_between_services' => 20,
                    'services_types_id' => $serviceType->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Tests spécifiques pour insuffisance cardiaque',
                    'description' => 'Analyse avancée pour détecter d\'éventuelles maladies cardiaques chroniques.',
                    'price' => 80.00,
                    'duration' => 40,
                    'gap_between_services' => 15,
                    'services_types_id' => $serviceType->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Ajustement des traitements pour pathologies chroniques',
                    'description' => 'Consultation pour ajuster les traitements médicamenteux et alimentaires des animaux souffrant de pathologies cardiaques.',
                    'price' => 50.00,
                    'duration' => 30,
                    'gap_between_services' => 10,
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
            'Électrocardiogramme (ECG)',
            'Échographie cardiaque (doppler)',
            'Tests spécifiques pour insuffisance cardiaque',
            'Ajustement des traitements pour pathologies chroniques',
        ])->delete();
    }
};
