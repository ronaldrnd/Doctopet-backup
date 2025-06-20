<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateComportementAnimalVeterinaireSpecialty extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Récupérer ou créer la spécialité "Comportementaliste vétérinaire"
            $specialite_id = DB::table('specialites')->where('nom', 'Comportementaliste vétérinaire')->value('id');

            if (!$specialite_id) {
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Comportementaliste vétérinaire',
                    'description' => 'Spécialisation dans l’étude et la correction des troubles comportementaux des animaux.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 2 : Supprimer les relations existantes avec cette spécialité
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

            // 🔹 Étape 3 : Créer ou récupérer les services_types spécifiques à la spécialité
            $services_types = [
                'Consultations comportementales' => '#8E44AD', // Violet foncé
                'Suivi personnalisé' => '#3498DB', // Bleu clair
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

            // 🔹 Étape 4 : Associer les services_types à la spécialité "Comportementaliste vétérinaire"
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
                'Consultations comportementales' => [
                    [
                        'name' => 'Diagnostic des troubles comportementaux (anxiété, agressivité)',
                        'description' => 'Analyse des troubles comportementaux tels que l’anxiété ou l’agressivité chez l’animal.',
                        'price' => 80.00,
                        'duration' => 60,
                        'gap_between_services' => 15,
                    ],
                    [
                        'name' => 'Mise en place de thérapies comportementales adaptées',
                        'description' => 'Traitement personnalisé pour améliorer le comportement de l’animal.',
                        'price' => 100.00,
                        'duration' => 60,
                        'gap_between_services' => 20,
                    ],
                ],
                'Suivi personnalisé' => [
                    [
                        'name' => 'Travail en collaboration avec un éducateur canin ou propriétaire',
                        'description' => 'Suivi des animaux en collaboration avec un éducateur canin ou le propriétaire.',
                        'price' => 70.00,
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
            // 🔹 Étape 1 : Supprimer les relations avec la spécialité "Comportementaliste vétérinaire"
            $specialite_id = DB::table('specialites')->where('nom', 'Comportementaliste vétérinaire')->value('id');

            if ($specialite_id) {
                DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();
            }

            // 🔹 Étape 2 : Supprimer les services_types créés
            $services_types_ids = DB::table('services_types')
                ->whereIn('libelle', ['Consultations comportementales', 'Suivi personnalisé'])
                ->pluck('id');

            DB::table('services_types')->whereIn('id', $services_types_ids)->delete();

            // 🔹 Étape 3 : Supprimer les services_templates créés
            DB::table('service_templates')
                ->whereIn('name', [
                    'Diagnostic des troubles comportementaux (anxiété, agressivité)',
                    'Mise en place de thérapies comportementales adaptées',
                    'Travail en collaboration avec un éducateur canin ou propriétaire',
                ])
                ->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Erreur dans la suppression de la migration : " . $e->getMessage());
        }
    }
}
