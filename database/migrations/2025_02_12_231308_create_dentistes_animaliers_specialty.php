<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDentistesAnimaliersSpecialty extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Récupérer ou créer la spécialité "Dentistes animaliers"
            $specialite_id = DB::table('specialites')->where('nom', 'Dentistes animaliers')->value('id');

            if (!$specialite_id) {
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Dentistes animaliers',
                    'description' => 'Services spécialisés en soins dentaires et prévention pour la santé buccale des animaux.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 2 : Supprimer les relations existantes avec cette spécialité
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

            // 🔹 Étape 3 : Créer ou récupérer les services_types spécifiques
            $services_types = [
                'Soins dentaires (Dentiste animalier)' => '#7D3C98', // Violet foncé
                'Prévention (Dentiste animalier)' => '#1ABC9C', // Turquoise
            ];

            $services_types_ids = [];

            foreach ($services_types as $libelle => $color) {
                $existing_service = DB::table('services_types')->where('libelle', $libelle)->first();

                if ($existing_service) {
                    $services_types_ids[$libelle] = $existing_service->id;
                } else {
                    $services_types_ids[$libelle] = DB::table('services_types')->insertGetId([
                        'libelle' => $libelle,
                        'color_tag' => $color,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // 🔹 Étape 4 : Associer les services_types à la spécialité "Dentistes animaliers"
            foreach ($services_types_ids as $service_id) {
                DB::table('specialite_services_types')->insert([
                    'specialite_id' => $specialite_id,
                    'services_types_id' => $service_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 5 : Vérifier et insérer les services_templates
            $services_templates = [
                'Soins dentaires (Dentiste animalier)' => [
                    [
                        'name' => 'Détartrage et polissage',
                        'description' => 'Nettoyage complet des dents pour éliminer le tartre et maintenir une bonne hygiène buccale.',
                        'price' => 70.00,
                        'duration' => 60,
                        'gap_between_services' => 30,
                    ],
                    [
                        'name' => 'Extraction de dents malades',
                        'description' => 'Procédure d’extraction pour éliminer les dents endommagées ou infectées.',
                        'price' => 100.00,
                        'duration' => 90,
                        'gap_between_services' => 30,
                    ],
                ],
                'Prévention (Dentiste animalier)' => [
                    [
                        'name' => 'Consultation pour hygiène buccale',
                        'description' => 'Examen complet de la bouche et recommandations pour la santé dentaire.',
                        'price' => 40.00,
                        'duration' => 45,
                        'gap_between_services' => 30,
                    ],
                    [
                        'name' => 'Conseils pour prévention des caries',
                        'description' => 'Recommandations personnalisées pour prévenir les infections et caries dentaires.',
                        'price' => 35.00,
                        'duration' => 45,
                        'gap_between_services' => 30,
                    ],
                ],
            ];

            foreach ($services_templates as $service_type => $templates) {
                foreach ($templates as $template) {
                    // Vérifier si le service template existe déjà
                    $existing_template = DB::table('service_templates')->where('name', $template['name'])->first();

                    // S'il existe, on le supprime avant de le recréer
                    if ($existing_template) {
                        DB::table('service_templates')->where('id', $existing_template->id)->delete();
                    }

                    // Insérer le service template avec l'ID correct du service type
                    DB::table('service_templates')->insert([
                        'name' => $template['name'],
                        'description' => $template['description'],
                        'price' => $template['price'],
                        'duration' => $template['duration'],
                        'gap_between_services' => $template['gap_between_services'],
                        'services_types_id' => $services_types_ids[$service_type],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Erreur dans la migration : " . $e->getMessage());
        }
    }

    public function down()
    {
        // 🔹 Étape 1 : Récupérer les IDs des services types à supprimer
        $services_types_ids = DB::table('services_types')
            ->whereIn('libelle', ['Soins dentaires (Dentiste animalier)', 'Prévention (Dentiste animalier)'])
            ->pluck('id');

        // 🔹 Étape 2 : Supprimer les liens avec `specialite_services_types`
        DB::table('specialite_services_types')
            ->whereIn('services_types_id', $services_types_ids)
            ->delete();

        // 🔹 Étape 3 : Supprimer les services templates associés
        DB::table('service_templates')
            ->whereIn('services_types_id', $services_types_ids)
            ->delete();

        // 🔹 Étape 4 : Supprimer les services types eux-mêmes
        DB::table('services_types')
            ->whereIn('id', $services_types_ids)
            ->delete();

        // 🔹 Étape 5 : Supprimer la spécialité "Dentistes animaliers"
        DB::table('specialites')->where('nom', 'Dentistes animaliers')->delete();
    }
}
