<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateNutritionnistesAnimaliersSpecialty extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Récupérer ou créer la spécialité "Nutritionnistes animaliers"
            $specialite_id = DB::table('specialites')->where('nom', 'Nutritionnistes animaliers')->value('id');

            if (!$specialite_id) {
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Nutritionnistes animaliers',
                    'description' => 'Services spécialisés en planification et suivi nutritionnel pour animaux.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 2 : Supprimer les relations existantes avec cette spécialité
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

            // 🔹 Étape 3 : Créer ou récupérer les services_types spécifiques
            $services_types = [
                'Planification alimentaire (Nutritionniste)' => '#27AE60', // Vert
                'Suivi personnalisé (Nutritionniste)' => '#2980B9', // Bleu
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

            // 🔹 Étape 4 : Associer les services_types à la spécialité "Nutritionnistes animaliers"
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
                'Planification alimentaire (Nutritionniste)' => [
                    [
                        'name' => 'Élaboration de plans nutritionnels adaptés à l’animal',
                        'description' => 'Création de plans alimentaires sur mesure pour répondre aux besoins spécifiques de l’animal.',
                        'price' => 50.00,
                        'duration' => 60,
                        'gap_between_services' => 30,
                    ],
                    [
                        'name' => 'Ajustements alimentaires pour animaux souffrant de pathologies',
                        'description' => 'Conseils diététiques pour adapter l’alimentation des animaux avec des problèmes de santé.',
                        'price' => 55.00,
                        'duration' => 60,
                        'gap_between_services' => 30,
                    ],
                ],
                'Suivi personnalisé (Nutritionniste)' => [
                    [
                        'name' => 'Contrôle des progrès de santé liés à la nutrition',
                        'description' => 'Suivi des performances alimentaires et ajustement des régimes.',
                        'price' => 40.00,
                        'duration' => 45,
                        'gap_between_services' => 30,
                    ],
                    [
                        'name' => 'Conseils pour transition alimentaire',
                        'description' => 'Accompagnement dans le changement de régime pour éviter les troubles digestifs.',
                        'price' => 30.00,
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
            ->whereIn('libelle', ['Planification alimentaire (Nutritionniste)', 'Suivi personnalisé (Nutritionniste)'])
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

        // 🔹 Étape 5 : Supprimer la spécialité "Nutritionnistes animaliers"
        DB::table('specialites')->where('nom', 'Nutritionnistes animaliers')->delete();
    }
}
