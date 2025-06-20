<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateNeurologieVeterinaireSpecialty extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Récupérer ou créer la spécialité "Neurologie vétérinaire"
            $specialite_id = DB::table('specialites')->where('nom', 'Neurologie vétérinaire')->value('id');

            if (!$specialite_id) {
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Neurologie vétérinaire',
                    'description' => 'Diagnostic et traitement des troubles neurologiques chez les animaux.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 2 : Supprimer les relations existantes
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

            // 🔹 Étape 3 : Créer ou récupérer les services_types "Diagnostic" et "Traitements"
            $services_types = [
                'Diagnostic (Neurologique)' => '#8E44AD', // Violet foncé
                'Traitements (Neurologique)' => '#2ECC71', // Vert
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

            // 🔹 Étape 4 : Associer les services_types à la spécialité "Neurologie vétérinaire"
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
                'Diagnostic (Neurologique)' => [
                    [
                        'name' => 'Consultation pour troubles neurologiques',
                        'description' => 'Évaluation des troubles neurologiques tels que l\'épilepsie et la paralysie.',
                        'price' => 90.00,
                        'duration' => 60,
                        'gap_between_services' => 20,
                    ],
                    [
                        'name' => 'IRM pour détection des lésions cérébrales ou nerveuses',
                        'description' => 'Imagerie avancée pour identifier des lésions neurologiques et cérébrales.',
                        'price' => 300.00,
                        'duration' => 120,
                        'gap_between_services' => 30,
                    ],
                ],
                'Traitements (Neurologique)' => [
                    [
                        'name' => 'Mise en place de protocoles pour gestion des crises d’épilepsie',
                        'description' => 'Mise en place d\'un protocole de traitement adapté pour les crises d’épilepsie.',
                        'price' => 100.00,
                        'duration' => 45,
                        'gap_between_services' => 15,
                    ],
                    [
                        'name' => 'Réhabilitation post-traumatique ou chirurgicale',
                        'description' => 'Programme de rééducation pour récupération après un traumatisme ou une chirurgie neurologique.',
                        'price' => 120.00,
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
            // 🔹 Étape 1 : Supprimer les relations avec la spécialité "Neurologie vétérinaire"
            $specialite_id = DB::table('specialites')->where('nom', 'Neurologie vétérinaire')->value('id');

            if ($specialite_id) {
                DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();
            }

            // 🔹 Étape 2 : Supprimer les services_types créés
            $services_types_ids = DB::table('services_types')
                ->whereIn('libelle', ['Diagnostic', 'Traitements'])
                ->pluck('id');

            DB::table('services_types')->whereIn('id', $services_types_ids)->delete();

            // 🔹 Étape 3 : Supprimer les services_templates créés
            DB::table('service_templates')
                ->whereIn('name', [
                    'Consultation pour troubles neurologiques',
                    'IRM pour détection des lésions cérébrales ou nerveuses',
                    'Mise en place de protocoles pour gestion des crises d’épilepsie',
                    'Réhabilitation post-traumatique ou chirurgicale',
                ])
                ->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Erreur dans la suppression de la migration : " . $e->getMessage());
        }
    }
}
