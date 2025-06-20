<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOsteopathesAnimaliersSpecialty extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Récupérer ou créer la spécialité "Ostéopathes animaliers"
            $specialite_id = DB::table('specialites')->where('nom', 'Ostéopathes animaliers')->value('id');

            if (!$specialite_id) {
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Ostéopathes animaliers',
                    'description' => 'Soins ostéopathiques pour améliorer la mobilité et soulager les douleurs des animaux.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 2 : Supprimer les relations existantes avec cette spécialité
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

            // 🔹 Étape 3 : Créer ou récupérer les services_types spécifiques
            $services_types = [
                'Soins ostéopathiques' => '#16A085', // Vert
                'Prévention et bien-être' => '#F39C12', // Orange
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

            // 🔹 Étape 4 : Associer les services_types à la spécialité
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
                'Soins ostéopathiques' => [
                    [
                        'name' => 'Gestion des douleurs musculo-squelettiques',
                        'description' => 'Techniques pour soulager douleurs musculaires et tensions articulaires.',
                        'price' => 70.00,
                        'duration' => 60,
                        'gap_between_services' => 30,
                    ],
                    [
                        'name' => 'Traitement des troubles articulaires (arthrose, dysplasie)',
                        'description' => 'Soins spécifiques pour arthrose, dysplasie et autres pathologies articulaires.',
                        'price' => 80.00,
                        'duration' => 60,
                        'gap_between_services' => 30,
                    ],
                    [
                        'name' => 'Soins post-traumatiques (accidents, chutes)',
                        'description' => 'Rééducation après accident ou chirurgie pour restaurer la mobilité.',
                        'price' => 85.00,
                        'duration' => 75,
                        'gap_between_services' => 30,
                    ],
                ],
                'Prévention et bien-être' => [
                    [
                        'name' => 'Suivi des animaux de sport ou de compétition',
                        'description' => 'Accompagnement des chiens et chevaux sportifs pour maintenir leur performance.',
                        'price' => 90.00,
                        'duration' => 60,
                        'gap_between_services' => 30,
                    ],
                    [
                        'name' => 'Amélioration de la mobilité générale',
                        'description' => 'Techniques pour améliorer la flexibilité et la motricité des animaux vieillissants.',
                        'price' => 75.00,
                        'duration' => 60,
                        'gap_between_services' => 30,
                    ],
                ],
            ];

            foreach ($services_templates as $service_type => $templates) {
                foreach ($templates as $template) {
                    $existing_template = DB::table('service_templates')->where('name', $template['name'])->first();

                    if (!$existing_template) {
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
            ->whereIn('libelle', ['Soins ostéopathiques', 'Prévention et bien-être'])
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

        // 🔹 Étape 5 : Supprimer la spécialité "Ostéopathes animaliers"
        DB::table('specialites')->where('nom', 'Ostéopathes animaliers')->delete();
    }
}
