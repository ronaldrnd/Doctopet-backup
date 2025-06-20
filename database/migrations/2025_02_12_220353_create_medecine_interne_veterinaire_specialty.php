<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMedecineInterneVeterinaireSpecialty extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Récupérer ou créer la spécialité "Médecine interne vétérinaire"
            $specialite_id = DB::table('specialites')->where('nom', 'Médecine interne vétérinaire')->value('id');

            if (!$specialite_id) {
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Médecine interne vétérinaire',
                    'description' => 'Diagnostic et prise en charge des maladies chroniques et internes des animaux.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 2 : Supprimer les relations existantes
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

            // 🔹 Étape 3 : Créer ou récupérer les services_types spécifiques à la médecine interne
            $services_types = [
                'Pathologies digestives et rénales' => '#2E86C1', // Bleu
                'Maladies endocriniennes' => '#A569BD', // Violet
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

            // 🔹 Étape 4 : Associer les services_types à la spécialité "Médecine interne vétérinaire"
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
                'Pathologies digestives et rénales' => [
                    [
                        'name' => 'Consultation pour troubles digestifs',
                        'description' => 'Évaluation des vomissements, diarrhées et autres troubles digestifs.',
                        'price' => 80.00,
                        'duration' => 45,
                        'gap_between_services' => 15,
                    ],
                    [
                        'name' => 'Tests pour maladies rénales ou hépatiques',
                        'description' => 'Analyses sanguines et urinaires pour diagnostiquer des pathologies rénales ou hépatiques.',
                        'price' => 100.00,
                        'duration' => 60,
                        'gap_between_services' => 20,
                    ],
                ],
                'Maladies endocriniennes' => [
                    [
                        'name' => 'Diagnostic et gestion du diabète',
                        'description' => 'Mise en place de traitements et suivi pour les animaux diabétiques.',
                        'price' => 120.00,
                        'duration' => 60,
                        'gap_between_services' => 20,
                    ],
                    [
                        'name' => 'Soins pour troubles thyroïdiens',
                        'description' => 'Diagnostic et suivi des troubles hormonaux comme l\'hypothyroïdie et l\'hyperthyroïdie.',
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
            // 🔹 Étape 1 : Supprimer les relations avec la spécialité "Médecine interne vétérinaire"
            $specialite_id = DB::table('specialites')->where('nom', 'Médecine interne vétérinaire')->value('id');

            if ($specialite_id) {
                DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();
            }

            // 🔹 Étape 2 : Supprimer les services_types créés
            $services_types_ids = DB::table('services_types')
                ->whereIn('libelle', ['Pathologies digestives et rénales', 'Maladies endocriniennes'])
                ->pluck('id');

            DB::table('services_types')->whereIn('id', $services_types_ids)->delete();

            // 🔹 Étape 3 : Supprimer les services_templates créés
            DB::table('service_templates')
                ->whereIn('name', [
                    'Consultation pour troubles digestifs',
                    'Tests pour maladies rénales ou hépatiques',
                    'Diagnostic et gestion du diabète',
                    'Soins pour troubles thyroïdiens',
                ])
                ->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Erreur dans la suppression de la migration : " . $e->getMessage());
        }
    }
}
