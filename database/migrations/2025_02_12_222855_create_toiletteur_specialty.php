<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateToiletteurSpecialty extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Récupérer ou créer la spécialité "Toiletteur"
            $specialite_id = DB::table('specialites')->where('nom', 'Toiletteur')->value('id');

            if (!$specialite_id) {
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Toiletteur',
                    'description' => 'Services de soins esthétiques et d’hygiène pour animaux de compagnie.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 2 : Supprimer les relations existantes avec cette spécialité
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

            // 🔹 Étape 3 : Créer ou récupérer les services_types spécifiques à la spécialité
            $services_types = [
                'Soins de base (Toiletteur)' => '#3498DB', // Bleu
                'Entretien esthétique' => '#9B59B6', // Violet
                'Coupe et tonte' => '#E67E22', // Orange
                'Soins spécifiques' => '#16A085', // Vert turquoise
                'Hygiène et nettoyage' => '#F39C12', // Jaune
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

            // 🔹 Étape 4 : Associer les services_types à la spécialité "Toiletteur"
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
                'Soins de base (Toiletteur)' => [
                    [
                        'name' => 'Bain',
                        'description' => 'Bain simple pour assurer la propreté et le bien-être de l’animal.',
                        'price' => 30.00,
                        'duration' => 45,
                        'gap_between_services' => 15,
                    ],
                    [
                        'name' => 'Shampoing',
                        'description' => 'Lavage du pelage avec un shampoing adapté à l’animal.',
                        'price' => 35.00,
                        'duration' => 45,
                        'gap_between_services' => 15,
                    ],
                    [
                        'name' => 'Shampoing antiparasitaire',
                        'description' => 'Shampoing spécial pour lutter contre les puces et tiques.',
                        'price' => 40.00,
                        'duration' => 45,
                        'gap_between_services' => 15,
                    ],
                ],
                'Entretien esthétique' => [
                    [
                        'name' => 'Démêlage',
                        'description' => 'Démêlage doux et progressif du pelage pour éviter les nœuds.',
                        'price' => 25.00,
                        'duration' => 30,
                        'gap_between_services' => 10,
                    ],
                    [
                        'name' => 'Brushing',
                        'description' => 'Brushing pour donner un aspect soigné au pelage.',
                        'price' => 35.00,
                        'duration' => 40,
                        'gap_between_services' => 15,
                    ],
                    [
                        'name' => 'Brossage/débourrage',
                        'description' => 'Brossage en profondeur pour enlever les poils morts et redonner de l’éclat.',
                        'price' => 30.00,
                        'duration' => 40,
                        'gap_between_services' => 15,
                    ],
                ],
                'Coupe et tonte' => [
                    [
                        'name' => 'Coupe ciseau',
                        'description' => 'Coupe au ciseau pour une finition plus naturelle et élégante.',
                        'price' => 50.00,
                        'duration' => 60,
                        'gap_between_services' => 20,
                    ],
                    [
                        'name' => 'Coupe mouton',
                        'description' => 'Coupe uniforme pour les chiens à poils longs nécessitant un entretien facile.',
                        'price' => 45.00,
                        'duration' => 50,
                        'gap_between_services' => 20,
                    ],
                    [
                        'name' => 'Tondeuse',
                        'description' => 'Rasage avec tondeuse pour un entretien rapide et efficace.',
                        'price' => 40.00,
                        'duration' => 45,
                        'gap_between_services' => 15,
                    ],
                ],
                'Soins spécifiques' => [
                    [
                        'name' => 'Coupe des griffes',
                        'description' => 'Taille des griffes pour éviter les blessures et gênes pour l’animal.',
                        'price' => 15.00,
                        'duration' => 20,
                        'gap_between_services' => 10,
                    ],
                    [
                        'name' => 'Tour des pattes',
                        'description' => 'Entretien des poils autour des pattes pour un look soigné.',
                        'price' => 15.00,
                        'duration' => 20,
                        'gap_between_services' => 10,
                    ],
                    [
                        'name' => 'Épilation',
                        'description' => 'Élimination des poils morts pour les races nécessitant un épilage.',
                        'price' => 50.00,
                        'duration' => 60,
                        'gap_between_services' => 20,
                    ],
                    [
                        'name' => 'Vidange des glandes anales',
                        'description' => 'Vidange des glandes anales pour prévenir les infections.',
                        'price' => 20.00,
                        'duration' => 20,
                        'gap_between_services' => 10,
                    ],
                ],
                'Hygiène et nettoyage' => [
                    [
                        'name' => 'Nettoyage de la bouche',
                        'description' => 'Entretien de la bouche pour prévenir les infections et le tartre.',
                        'price' => 20.00,
                        'duration' => 20,
                        'gap_between_services' => 10,
                    ],
                    [
                        'name' => 'Nettoyage des yeux et oreilles',
                        'description' => 'Nettoyage des yeux et des oreilles pour éviter infections et accumulations de saletés.',
                        'price' => 20.00,
                        'duration' => 20,
                        'gap_between_services' => 10,
                    ],
                    [
                        'name' => 'Insectifuge',
                        'description' => 'Traitement contre les parasites externes.',
                        'price' => 25.00,
                        'duration' => 30,
                        'gap_between_services' => 10,
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
        // Suppression des relations et services liés
    }
}
