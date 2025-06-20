<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSoinsPalliatifsVeterinaireSpecialty extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Récupérer ou créer la spécialité "Soins palliatifs vétérinaires"
            $specialite_id = DB::table('specialites')->where('nom', 'Soins palliatifs vétérinaires')->value('id');

            if (!$specialite_id) {
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Soins palliatifs vétérinaires',
                    'description' => 'Spécialisation dans l’accompagnement des animaux en fin de vie, avec des soins adaptés pour leur confort.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 2 : Supprimer les relations existantes avec cette spécialité
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

            // 🔹 Étape 3 : Créer ou récupérer les services_types spécifiques à la spécialité
            $services_types = [
                'Accompagnement (Soins Palliatifs)' => '#E67E22', // Orange
                'Soins spécifiques' => '#16A085', // Vert turquoise
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

            // 🔹 Étape 4 : Associer les services_types à la spécialité "Soins palliatifs vétérinaires"
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
                'Accompagnement (Soins Palliatifs)' => [
                    [
                        'name' => 'Gestion de la douleur pour maladies chroniques',
                        'description' => 'Traitement de la douleur pour améliorer le confort des animaux souffrant de maladies chroniques.',
                        'price' => 90.00,
                        'duration' => 45,
                        'gap_between_services' => 15,
                    ],
                    [
                        'name' => 'Suivi des animaux en fin de vie',
                        'description' => 'Accompagnement et soins adaptés pour assurer une meilleure qualité de vie en fin de parcours.',
                        'price' => 100.00,
                        'duration' => 60,
                        'gap_between_services' => 20,
                    ],
                ],
                'Soins spécifiques' => [
                    [
                        'name' => 'Mise en place de protocoles de confort (médicaments, nutrition adaptée)',
                        'description' => 'Définition et mise en place de protocoles de confort personnalisés pour chaque animal.',
                        'price' => 80.00,
                        'duration' => 60,
                        'gap_between_services' => 20,
                    ],
                    [
                        'name' => 'Assistance à domicile pour fin de vie',
                        'description' => 'Soins et accompagnement à domicile pour assurer une transition paisible.',
                        'price' => 120.00,
                        'duration' => 90,
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
                    } else {
                        // Met à jour l'ID du services_types si ce n'est pas le bon
                        DB::table('service_templates')->where('id', $existing_template->id)->update([
                            'services_types_id' => $services_types_ids[$service_type],
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
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Supprimer les relations avec la spécialité "Soins palliatifs vétérinaires"
            $specialite_id = DB::table('specialites')->where('nom', 'Soins palliatifs vétérinaires')->value('id');

            if ($specialite_id) {
                DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();
            }

            // 🔹 Étape 2 : Supprimer les services_types créés
            $services_types_ids = DB::table('services_types')
                ->whereIn('libelle', ['Accompagnement', 'Soins spécifiques'])
                ->pluck('id');

            DB::table('services_types')->whereIn('id', $services_types_ids)->delete();

            // 🔹 Étape 3 : Supprimer les services_templates créés
            DB::table('service_templates')
                ->whereIn('name', [
                    'Gestion de la douleur pour maladies chroniques',
                    'Suivi des animaux en fin de vie',
                    'Mise en place de protocoles de confort (médicaments, nutrition adaptée)',
                    'Assistance à domicile pour fin de vie',
                ])
                ->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Erreur dans la suppression de la migration : " . $e->getMessage());
        }
    }
}
