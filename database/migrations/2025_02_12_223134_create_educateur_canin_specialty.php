<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEducateurCaninSpecialty extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Récupérer ou créer la spécialité "Éducateur canin"
            $specialite_id = DB::table('specialites')->where('nom', 'Éducateur canin')->value('id');

            if (!$specialite_id) {
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Éducateur canin',
                    'description' => 'Services d’éducation et de dressage pour chiens, incluant socialisation et gestion comportementale.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 2 : Supprimer les relations existantes avec cette spécialité
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

            // 🔹 Étape 3 : Créer ou récupérer les services_types spécifiques à la spécialité
            $services_types = [
                'Éducation comportementale' => '#1ABC9C', // Turquoise
                'Dressage' => '#F39C12', // Jaune
                'Ateliers spécifiques' => '#8E44AD', // Violet
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





            // 🔹 Étape 4 : Associer les services_types à la spécialité "Éducateur canin"
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
                'Éducation comportementale' => [
                    [
                        'name' => 'Rééducation comportementale (agressivité, anxiété, peurs)',
                        'description' => 'Correction des comportements indésirables (agressivité, anxiété, phobies).',
                        'price' => 60.00,
                        'duration' => 60,
                        'gap_between_services' => 30,
                    ],
                    [
                        'name' => 'Socialisation du chiot ou chien adulte',
                        'description' => 'Mise en contact avec d’autres chiens et humains pour un bon développement.',
                        'price' => 50.00,
                        'duration' => 45,
                        'gap_between_services' => 20,
                    ],
                    [
                        'name' => 'Gestion des aboiements excessifs',
                        'description' => 'Enseignement des bonnes pratiques pour limiter les aboiements inappropriés.',
                        'price' => 55.00,
                        'duration' => 50,
                        'gap_between_services' => 20,
                    ],
                    [
                        'name' => 'Apprentissage de la propreté',
                        'description' => 'Techniques et accompagnement pour aider les chiots et chiens adultes à être propres.',
                        'price' => 45.00,
                        'duration' => 40,
                        'gap_between_services' => 15,
                    ],
                ],
                'Dressage' => [
                    [
                        'name' => 'Obéissance de base (assis, rappel, marche en laisse)',
                        'description' => 'Cours d’obéissance de base : assis, couché, rappel, marche en laisse.',
                        'price' => 65.00,
                        'duration' => 60,
                        'gap_between_services' => 30,
                    ],
                    [
                        'name' => 'Dressage avancé (sport canin, compétences spécifiques)',
                        'description' => 'Enseignement des compétences avancées (sports canins, tricks, protection).',
                        'price' => 80.00,
                        'duration' => 90,
                        'gap_between_services' => 40,
                    ],
                ],
                'Ateliers spécifiques' => [
                    [
                        'name' => 'Préparation du chien à des activités (agility, pistage)',
                        'description' => 'Formation pour agility, pistage et autres disciplines sportives.',
                        'price' => 70.00,
                        'duration' => 75,
                        'gap_between_services' => 30,
                    ],
                    [
                        'name' => 'Sessions collectives pour socialisation',
                        'description' => 'Cours en groupe pour améliorer la sociabilité et les interactions.',
                        'price' => 40.00,
                        'duration' => 60,
                        'gap_between_services' => 20,
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
            ->whereIn('libelle', ['Éducation comportementale', 'Dressage', 'Ateliers spécifiques'])
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
    }


}
