<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCardiologieVeterinaireSpecialty extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Récupérer ou créer la spécialité "Cardiologie vétérinaire"
            $specialite_id = DB::table('specialites')->where('nom', 'Cardiologie vétérinaire')->value('id');

            if (!$specialite_id) {
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Cardiologie vétérinaire',
                    'description' => 'Spécialiste des maladies cardiaques et vasculaires chez les animaux.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 2 : Supprimer les relations existantes
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

            // 🔹 Étape 3 : Créer ou récupérer les services_types "Diagnostic" et "Suivi"
            $services_types = [
                'Diagnostic' => '#E74C3C', // Rouge
                'Suivi' => '#2ECC71', // Vert
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

            // 🔹 Étape 4 : Associer les services_types à la spécialité "Cardiologie vétérinaire"
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
                'Diagnostic (Cardiologie)' => [
                    [
                        'name' => 'Électrocardiogramme (ECG)',
                        'description' => 'Examen permettant d\'analyser l\'activité électrique du cœur de votre animal.',
                        'price' => 60.00,
                        'duration' => 30,
                        'gap_between_services' => 15,
                    ],
                    [
                        'name' => 'Échographie cardiaque (doppler)',
                        'description' => 'Évaluation des structures cardiaques et du flux sanguin à l\'aide d\'ultrasons.',
                        'price' => 100.00,
                        'duration' => 45,
                        'gap_between_services' => 20,
                    ],
                    [
                        'name' => 'Tests spécifiques pour insuffisance cardiaque',
                        'description' => 'Analyse avancée pour détecter d\'éventuelles maladies cardiaques chroniques.',
                        'price' => 80.00,
                        'duration' => 40,
                        'gap_between_services' => 15,
                    ],
                ],
                'Suivi (Cardiologie)' => [
                    [
                        'name' => 'Ajustement des traitements pour pathologies chroniques',
                        'description' => 'Consultation pour ajuster les traitements médicamenteux et alimentaires des animaux souffrant de pathologies cardiaques.',
                        'price' => 50.00,
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
            // 🔹 Étape 1 : Supprimer les relations avec la spécialité "Cardiologie vétérinaire"
            $specialite_id = DB::table('specialites')->where('nom', 'Cardiologie vétérinaire')->value('id');

            if ($specialite_id) {
                DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();
            }

            // 🔹 Étape 2 : Supprimer les services_types créés
            $services_types_ids = DB::table('services_types')
                ->whereIn('libelle', ['Diagnostic', 'Suivi'])
                ->pluck('id');

            DB::table('services_types')->whereIn('id', $services_types_ids)->delete();

            // 🔹 Étape 3 : Supprimer les services_templates créés
            DB::table('service_templates')
                ->whereIn('name', [
                    'Électrocardiogramme (ECG)',
                    'Échographie cardiaque (doppler)',
                    'Tests spécifiques pour insuffisance cardiaque',
                    'Ajustement des traitements pour pathologies chroniques',
                ])
                ->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Erreur dans la suppression de la migration : " . $e->getMessage());
        }
    }
}
