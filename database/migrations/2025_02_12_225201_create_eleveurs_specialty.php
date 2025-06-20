<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEleveursSpecialty extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Récupérer ou créer la spécialité "Éleveurs"
            $specialite_id = DB::table('specialites')->where('nom', 'Éleveurs')->value('id');

            if (!$specialite_id) {
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Éleveurs',
                    'description' => 'Services spécialisés dans l’élevage, la sélection génétique et l’adoption d’animaux.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 2 : Supprimer les relations existantes avec cette spécialité
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

            // 🔹 Étape 3 : Créer ou récupérer les services_types spécifiques
            $services_types = [
                'Élevage spécialisé' => '#9B59B6', // Violet foncé
                'Services annexes' => '#3498DB', // Bleu
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

            // 🔹 Étape 4 : Associer les services_types à la spécialité "Éleveurs"
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
                'Élevage spécialisé' => [
                    [
                        'name' => 'Rencontre des animaux pour adoption ou achat (chiots/chatons)',
                        'description' => 'Organisez une visite pour rencontrer les animaux avant adoption ou achat.',
                        'price' => 0.00,
                        'duration' => 30,
                        'gap_between_services' => 10,
                    ],
                    [
                        'name' => 'Sélection génétique et conseils sur les races',
                        'description' => 'Conseils personnalisés pour choisir la race adaptée à votre mode de vie.',
                        'price' => 50.00,
                        'duration' => 60,
                        'gap_between_services' => 30,
                    ],
                ],
                'Services annexes' => [
                    [
                        'name' => 'Préparation des documents administratifs liés à l’adoption',
                        'description' => 'Assistance dans la constitution du dossier pour l’adoption d’un animal.',
                        'price' => 30.00,
                        'duration' => 30,
                        'gap_between_services' => 15,
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
            ->whereIn('libelle', ['Élevage spécialisé', 'Services annexes'])
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

        // 🔹 Étape 5 : Supprimer la spécialité "Éleveurs"
        DB::table('specialites')->where('nom', 'Éleveurs')->delete();
    }
}
