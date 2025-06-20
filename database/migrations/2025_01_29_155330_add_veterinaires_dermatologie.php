<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Récupération de l'ID du service_type correspondant
        $servicesTypes = DB::table('services_types')->pluck('id', 'libelle');

        DB::table('service_templates')->insert([
            // **DIAGNOSTIC ET TRAITEMENT DES PATHOLOGIES CUTANÉES**
            [
                'name' => 'Consultation pour allergies cutanées',
                'description' => 'Consultation spécialisée pour diagnostiquer et traiter les allergies cutanées chez les animaux.',
                'price' => 80.00,
                'duration' => 45,
                'gap_between_services' => 15,
                'services_types_id' => $servicesTypes['Dermatologie']
            ],
            [
                'name' => 'Diagnostic des infections bactériennes ou fongiques',
                'description' => 'Examen approfondi pour identifier les infections bactériennes et fongiques de la peau.',
                'price' => 85.00,
                'duration' => 50,
                'gap_between_services' => 15,
                'services_types_id' => $servicesTypes['Dermatologie']
            ],
            [
                'name' => 'Détection des parasites externes (puces, tiques, gales)',
                'description' => 'Examen dermatologique pour détecter et traiter les infestations parasitaires externes.',
                'price' => 70.00,
                'duration' => 40,
                'gap_between_services' => 10,
                'services_types_id' => $servicesTypes['Dermatologie']
            ],

            // **SOINS SPÉCIFIQUES**
            [
                'name' => 'Mise en place de traitements dermatologiques (lotions, injections)',
                'description' => 'Application de traitements topiques ou injections pour les affections cutanées.',
                'price' => 90.00,
                'duration' => 60,
                'gap_between_services' => 20,
                'services_types_id' => $servicesTypes['Dermatologie']
            ],
            [
                'name' => 'Bains médicaux sous supervision',
                'description' => 'Séance de bain médicalisé sous surveillance vétérinaire pour apaiser les problèmes dermatologiques.',
                'price' => 100.00,
                'duration' => 60,
                'gap_between_services' => 20,
                'services_types_id' => $servicesTypes['Dermatologie']
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('service_templates')->whereIn('name', [
            'Consultation pour allergies cutanées',
            'Diagnostic des infections bactériennes ou fongiques',
            'Détection des parasites externes (puces, tiques, gales)',
            'Mise en place de traitements dermatologiques (lotions, injections)',
            'Bains médicaux sous supervision'
        ])->delete();
    }
};
