<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOphtalmologieVeterinaireSpecialty extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Récupérer ou créer la spécialité "Ophtalmologie vétérinaire"
            $specialite_id = DB::table('specialites')->where('nom', 'Ophtalmologie vétérinaire')->value('id');

            if (!$specialite_id) {
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Ophtalmologie vétérinaire',
                    'description' => 'Diagnostic et traitement des pathologies oculaires chez les animaux.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 2 : Supprimer les relations existantes
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

            // 🔹 Étape 3 : Créer ou récupérer les services_types "Consultations" et "Soins chirurgicaux"
            $services_types = [
                'Consultations' => '#3498DB', // Bleu
                'Soins chirurgicaux' => '#E74C3C', // Rouge
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

            // 🔹 Étape 4 : Associer les services_types à la spécialité "Ophtalmologie vétérinaire"
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
                'Consultations' => [
                    [
                        'name' => 'Diagnostic des maladies des yeux',
                        'description' => 'Consultation spécialisée pour détecter des pathologies comme les ulcères cornéens ou les glaucomes.',
                        'price' => 70.00,
                        'duration' => 40,
                        'gap_between_services' => 15,
                    ],
                    [
                        'name' => 'Contrôle de la vision et tests spécifiques',
                        'description' => 'Examen approfondi de la vision de l\'animal avec tests spécialisés.',
                        'price' => 50.00,
                        'duration' => 30,
                        'gap_between_services' => 10,
                    ],
                ],
                'Soins chirurgicaux' => [
                    [
                        'name' => 'Chirurgie des paupières (entropion, ectropion)',
                        'description' => 'Intervention chirurgicale pour corriger les anomalies des paupières.',
                        'price' => 250.00,
                        'duration' => 90,
                        'gap_between_services' => 30,
                    ],
                    [
                        'name' => 'Ablation de cataractes',
                        'description' => 'Opération chirurgicale pour retirer la cataracte et améliorer la vision.',
                        'price' => 600.00,
                        'duration' => 120,
                        'gap_between_services' => 45,
                    ],
                    [
                        'name' => 'Correction des ulcères cornéens',
                        'description' => 'Traitement chirurgical ou médicamenteux pour soigner les ulcères de la cornée.',
                        'price' => 150.00,
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
            // 🔹 Étape 1 : Supprimer les relations avec la spécialité "Ophtalmologie vétérinaire"
            $specialite_id = DB::table('specialites')->where('nom', 'Ophtalmologie vétérinaire')->value('id');

            if ($specialite_id) {
                DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();
            }

            // 🔹 Étape 2 : Supprimer les services_types créés
            $services_types_ids = DB::table('services_types')
                ->whereIn('libelle', ['Consultations', 'Soins chirurgicaux'])
                ->pluck('id');

            DB::table('services_types')->whereIn('id', $services_types_ids)->delete();

            // 🔹 Étape 3 : Supprimer les services_templates créés
            DB::table('service_templates')
                ->whereIn('name', [
                    'Diagnostic des maladies des yeux',
                    'Contrôle de la vision et tests spécifiques',
                    'Chirurgie des paupières (entropion, ectropion)',
                    'Ablation de cataractes',
                    'Correction des ulcères cornéens',
                ])
                ->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Erreur dans la suppression de la migration : " . $e->getMessage());
        }
    }
}
