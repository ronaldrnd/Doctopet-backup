<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Récupérer les ID des services types correspondants
        $nutrition = DB::table('services_types')->where('libelle', 'Nutrition')->first();
        $dentisterie = DB::table('services_types')->where('libelle', 'Dentisterie')->first();
        $asv = DB::table('services_types')->where('libelle', 'Auxiliaires vétérinaires')->first();
        $cremation = DB::table('services_types')->where('libelle', 'Crémation')->first();

        if ($nutrition) {
            DB::table('service_templates')->insert([
                // 🥦 Nutrition animale
                [
                    'name' => 'Élaboration de plans nutritionnels adaptés à l’animal',
                    'description' => 'Création de plans alimentaires sur mesure pour répondre aux besoins spécifiques de l’animal.',
                    'price' => 50.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $nutrition->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Ajustements alimentaires pour animaux souffrant de pathologies',
                    'description' => 'Conseils diététiques pour adapter l’alimentation des animaux avec des problèmes de santé.',
                    'price' => 55.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $nutrition->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Contrôle des progrès de santé liés à la nutrition',
                    'description' => 'Suivi des performances alimentaires et ajustement des régimes.',
                    'price' => 40.00,
                    'duration' => 45,
                    'gap_between_services' => 30,
                    'services_types_id' => $nutrition->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Conseils pour transition alimentaire',
                    'description' => 'Accompagnement dans le changement de régime pour éviter les troubles digestifs.',
                    'price' => 30.00,
                    'duration' => 45,
                    'gap_between_services' => 30,
                    'services_types_id' => $nutrition->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        if ($dentisterie) {
            DB::table('service_templates')->insert([
                // 🦷 Dentisterie animale
                [
                    'name' => 'Détartrage et polissage',
                    'description' => 'Nettoyage complet des dents pour éliminer le tartre et maintenir une bonne hygiène buccale.',
                    'price' => 70.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $dentisterie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Extraction de dents malades',
                    'description' => 'Procédure d’extraction pour éliminer les dents endommagées ou infectées.',
                    'price' => 100.00,
                    'duration' => 90,
                    'gap_between_services' => 30,
                    'services_types_id' => $dentisterie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Consultation pour hygiène buccale',
                    'description' => 'Examen complet de la bouche et recommandations pour la santé dentaire.',
                    'price' => 40.00,
                    'duration' => 45,
                    'gap_between_services' => 30,
                    'services_types_id' => $dentisterie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Conseils pour prévention des caries',
                    'description' => 'Recommandations personnalisées pour prévenir les infections et caries dentaires.',
                    'price' => 35.00,
                    'duration' => 45,
                    'gap_between_services' => 30,
                    'services_types_id' => $dentisterie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        if ($asv) {
            DB::table('service_templates')->insert([
                // 🏥 Auxiliaires vétérinaires (ASV)
                [
                    'name' => 'Préparation des animaux pour intervention vétérinaire',
                    'description' => 'Préparation des animaux avant une opération ou un examen médical.',
                    'price' => 30.00,
                    'duration' => 45,
                    'gap_between_services' => 15,
                    'services_types_id' => $asv->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Gestion des dossiers administratifs',
                    'description' => 'Organisation et suivi des dossiers médicaux et rendez-vous des patients.',
                    'price' => 25.00,
                    'duration' => 30,
                    'gap_between_services' => 15,
                    'services_types_id' => $asv->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Pose de pansements',
                    'description' => 'Changement et suivi des pansements post-opératoires.',
                    'price' => 20.00,
                    'duration' => 30,
                    'gap_between_services' => 15,
                    'services_types_id' => $asv->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Administration de médicaments sous supervision',
                    'description' => 'Administration de médicaments prescrits sous la supervision d’un vétérinaire.',
                    'price' => 25.00,
                    'duration' => 30,
                    'gap_between_services' => 15,
                    'services_types_id' => $asv->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }

        if ($cremation) {
            DB::table('service_templates')->insert([
                // ⚰️ Crématorium
                [
                    'name' => 'Crémation individuelle avec urne personnalisée',
                    'description' => 'Service de crémation avec récupération des cendres dans une urne.',
                    'price' => 150.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $cremation->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Crémation collective',
                    'description' => 'Crémation sans récupération des cendres.',
                    'price' => 80.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $cremation->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Transport du corps de l’animal',
                    'description' => 'Service de transport du corps de l’animal depuis le domicile ou la clinique vétérinaire jusqu’au crématorium.',
                    'price' => 50.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $cremation->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Hommages personnalisés pour les propriétaires',
                    'description' => 'Service de commémoration avec options de personnalisation (photo, plaque, cérémonie).',
                    'price' => 80.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $cremation->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

            ]);
        }
    }
};

