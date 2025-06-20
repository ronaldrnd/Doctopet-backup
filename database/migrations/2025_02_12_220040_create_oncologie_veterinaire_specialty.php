<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOncologieVeterinaireSpecialty extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Récupérer ou créer la spécialité "Oncologie vétérinaire"
            $specialite_id = DB::table('specialites')->where('nom', 'Oncologie vétérinaire')->value('id');

            if (!$specialite_id) {
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Oncologie vétérinaire',
                    'description' => 'Diagnostic et traitement des cancers chez les animaux.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 2 : Supprimer les relations existantes
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

            // 🔹 Étape 3 : Créer ou récupérer les services_types spécifiques à l'oncologie
            $services_types = [
                'Diagnostic des cancers' => '#C0392B', // Rouge foncé
                'Traitement (oncologie)' => '#27AE60', // Vert foncé
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

            // 🔹 Étape 4 : Associer les services_types à la spécialité "Oncologie vétérinaire"
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
                'Diagnostic des cancers' => [
                    [
                        'name' => 'Biopsies et analyses histopathologiques',
                        'description' => 'Prélèvement et analyse de tissus pour diagnostiquer un cancer chez l\'animal.',
                        'price' => 150.00,
                        'duration' => 60,
                        'gap_between_services' => 20,
                    ],
                    [
                        'name' => 'Scans ou imagerie pour évaluer la propagation',
                        'description' => 'Utilisation d\'imagerie avancée pour détecter l\'étendue des cancers.',
                        'price' => 350.00,
                        'duration' => 120,
                        'gap_between_services' => 30,
                    ],
                ],
                'Traitement (oncologie)' => [
                    [
                        'name' => 'Chimiothérapie ou radiothérapie',
                        'description' => 'Traitement par chimiothérapie ou radiothérapie pour lutter contre les cancers.',
                        'price' => 500.00,
                        'duration' => 90,
                        'gap_between_services' => 30,
                    ],
                    [
                        'name' => 'Chirurgie pour ablation des masses cancéreuses',
                        'description' => 'Intervention chirurgicale pour retirer des tumeurs malignes.',
                        'price' => 800.00,
                        'duration' => 180,
                        'gap_between_services' => 60,
                    ],
                    [
                        'name' => 'Suivi et ajustement des protocoles thérapeutiques',
                        'description' => 'Consultation régulière pour adapter le traitement du cancer de l\'animal.',
                        'price' => 100.00,
                        'duration' => 45,
                        'gap_between_services' => 15,
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
            // 🔹 Étape 1 : Supprimer les relations avec la spécialité "Oncologie vétérinaire"
            $specialite_id = DB::table('specialites')->where('nom', 'Oncologie vétérinaire')->value('id');

            if ($specialite_id) {
                DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();
            }

            // 🔹 Étape 2 : Supprimer les services_types créés
            $services_types_ids = DB::table('services_types')
                ->whereIn('libelle', ['Diagnostic des cancers', 'Traitement (oncologie)'])
                ->pluck('id');

            DB::table('services_types')->whereIn('id', $services_types_ids)->delete();

            // 🔹 Étape 3 : Supprimer les services_templates créés
            DB::table('service_templates')
                ->whereIn('name', [
                    'Biopsies et analyses histopathologiques',
                    'Scans ou imagerie pour évaluer la propagation',
                    'Chimiothérapie ou radiothérapie',
                    'Chirurgie pour ablation des masses cancéreuses',
                    'Suivi et ajustement des protocoles thérapeutiques',
                ])
                ->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Erreur dans la suppression de la migration : " . $e->getMessage());
        }
    }
}
