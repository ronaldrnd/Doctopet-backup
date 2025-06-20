<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Récupérer l'ID des services types "Neurologie" et "Oncologie"
        $neurologie = DB::table('services_types')->where('libelle', 'Neurologie')->first();
        $oncologie = DB::table('services_types')->where('libelle', 'Oncologie')->first();

        // Ajouter les services en neurologie
        if ($neurologie) {
            DB::table('service_templates')->insert([
                [
                    'name' => 'Consultation pour troubles neurologiques',
                    'description' => 'Évaluation des troubles neurologiques tels que l\'épilepsie et la paralysie.',
                    'price' => 90.00,
                    'duration' => 60,
                    'gap_between_services' => 20,
                    'services_types_id' => $neurologie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'IRM pour détection des lésions cérébrales ou nerveuses',
                    'description' => 'Imagerie avancée pour identifier des lésions neurologiques et cérébrales.',
                    'price' => 300.00,
                    'duration' => 120,
                    'gap_between_services' => 30,
                    'services_types_id' => $neurologie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Gestion des crises d’épilepsie',
                    'description' => 'Mise en place d\'un protocole de traitement adapté pour les crises d’épilepsie.',
                    'price' => 100.00,
                    'duration' => 45,
                    'gap_between_services' => 15,
                    'services_types_id' => $neurologie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Réhabilitation post-traumatique ou chirurgicale',
                    'description' => 'Programme de rééducation pour récupération après un traumatisme ou une chirurgie neurologique.',
                    'price' => 120.00,
                    'duration' => 60,
                    'gap_between_services' => 20,
                    'services_types_id' => $neurologie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        // Ajouter les services en oncologie
        if ($oncologie) {
            DB::table('service_templates')->insert([
                [
                    'name' => 'Biopsies et analyses histopathologiques',
                    'description' => 'Prélèvement et analyse de tissus pour diagnostiquer un cancer chez l\'animal.',
                    'price' => 150.00,
                    'duration' => 60,
                    'gap_between_services' => 20,
                    'services_types_id' => $oncologie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Scans ou imagerie pour évaluer la propagation',
                    'description' => 'Utilisation d\'imagerie avancée pour détecter l\'étendue des cancers.',
                    'price' => 350.00,
                    'duration' => 120,
                    'gap_between_services' => 30,
                    'services_types_id' => $oncologie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Chimiothérapie ou radiothérapie',
                    'description' => 'Traitement par chimiothérapie ou radiothérapie pour lutter contre les cancers.',
                    'price' => 500.00,
                    'duration' => 90,
                    'gap_between_services' => 30,
                    'services_types_id' => $oncologie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Chirurgie pour ablation des masses cancéreuses',
                    'description' => 'Intervention chirurgicale pour retirer des tumeurs malignes.',
                    'price' => 800.00,
                    'duration' => 180,
                    'gap_between_services' => 60,
                    'services_types_id' => $oncologie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Suivi et ajustement des protocoles thérapeutiques',
                    'description' => 'Consultation régulière pour adapter le traitement du cancer de l\'animal.',
                    'price' => 100.00,
                    'duration' => 45,
                    'gap_between_services' => 15,
                    'services_types_id' => $oncologie->id,
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
            'Consultation pour troubles neurologiques',
            'IRM pour détection des lésions cérébrales ou nerveuses',
            'Gestion des crises d’épilepsie',
            'Réhabilitation post-traumatique ou chirurgicale',
            'Biopsies et analyses histopathologiques',
            'Scans ou imagerie pour évaluer la propagation',
            'Chimiothérapie ou radiothérapie',
            'Chirurgie pour ablation des masses cancéreuses',
            'Suivi et ajustement des protocoles thérapeutiques',
        ])->delete();
    }
};
