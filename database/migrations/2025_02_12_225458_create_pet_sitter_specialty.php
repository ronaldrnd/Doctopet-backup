<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePetSitterSpecialty extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Récupérer ou créer la spécialité "Pet sitter"
            $specialite_id = DB::table('specialites')->where('nom', 'Pet sitter')->value('id');

            if (!$specialite_id) {
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Pet sitter',
                    'description' => 'Services de garde et d’entretien pour animaux de compagnie, incluant hébergement, promenades et visites à domicile.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 2 : Supprimer les relations existantes avec cette spécialité
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

            // 🔹 Étape 3 : Créer ou récupérer les services_types spécifiques
            $services_types = [
                'Entretien avec le pet sitter' => '#1ABC9C', // Turquoise
                'Services de garde' => '#E67E22', // Orange
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

            // 🔹 Étape 4 : Associer les services_types à la spécialité "Pet sitter"
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
                'Entretien avec le pet sitter' => [
                    [
                        'name' => 'Réserver un rendez-vous avec un pet-sitter',
                        'description' => 'Première rencontre avec le pet-sitter pour organiser la prise en charge de votre animal.',
                        'price' => 20.00,
                        'duration' => 30,
                        'gap_between_services' => 15,
                    ],
                ],
                'Services de garde' => [
                    [
                        'name' => 'Hébergement chez le pet-sitter',
                        'description' => 'Prise en charge complète de votre animal chez le pet-sitter.',
                        'price' => 35.00,
                        'duration' => 1440, // 1 jour
                        'gap_between_services' => 0,
                    ],
                    [
                        'name' => 'Garde à domicile chez vous',
                        'description' => 'Un pet-sitter s’occupe de votre animal directement chez vous.',
                        'price' => 40.00,
                        'duration' => 1440, // 1 jour
                        'gap_between_services' => 0,
                    ],
                    [
                        'name' => 'Visites à domicile',
                        'description' => 'Un pet-sitter passe chez vous pour nourrir et surveiller votre animal.',
                        'price' => 25.00,
                        'duration' => 30,
                        'gap_between_services' => 15,
                    ],
                    [
                        'name' => 'Garderie pour chien chez le pet-sitter',
                        'description' => 'Garde temporaire de votre chien dans un cadre sécurisé.',
                        'price' => 30.00,
                        'duration' => 480, // 8 heures
                        'gap_between_services' => 0,
                    ],
                    [
                        'name' => 'Promenade de chien dans votre quartier',
                        'description' => 'Sortie encadrée pour assurer l’exercice quotidien de votre chien.',
                        'price' => 15.00,
                        'duration' => 60,
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
            ->whereIn('libelle', ['Entretien avec le pet sitter', 'Services de garde'])
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

        // 🔹 Étape 5 : Supprimer la spécialité "Pet sitter"
        DB::table('specialites')->where('nom', 'Pet sitter')->delete();
    }
}
