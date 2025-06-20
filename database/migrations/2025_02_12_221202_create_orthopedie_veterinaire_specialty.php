<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrthopedieVeterinaireSpecialty extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Récupérer ou créer la spécialité "Orthopédie vétérinaire"
            $specialite_id = DB::table('specialites')->where('nom', 'Orthopédie vétérinaire')->value('id');

            if (!$specialite_id) {
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Orthopédie vétérinaire',
                    'description' => 'Spécialisation en diagnostic et traitements des pathologies orthopédiques, fractures et chirurgies osseuses.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 2 : Supprimer les relations existantes
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

            // 🔹 Étape 3 : Créer ou récupérer les services_types spécifiques à l’orthopédie vétérinaire
            $services_types = [
                'Diagnostic orthopédique' => '#5D6D7E', // Gris foncé
                'Chirurgies orthopédiques' => '#D35400', // Orange foncé
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

            // 🔹 Étape 4 : Associer les services_types à la spécialité "Orthopédie vétérinaire"
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
                'Diagnostic orthopédique' => [
                    [
                        'name' => 'Consultation pour boiteries ou douleurs articulaires',
                        'description' => 'Évaluation des troubles de la marche et des douleurs articulaires.',
                        'price' => 90.00,
                        'duration' => 45,
                        'gap_between_services' => 15,
                    ],
                    [
                        'name' => 'Tests spécifiques (hanches, genoux, coudes)',
                        'description' => 'Examens approfondis pour diagnostiquer les pathologies orthopédiques.',
                        'price' => 110.00,
                        'duration' => 60,
                        'gap_between_services' => 20,
                    ],
                ],
                'Chirurgies orthopédiques' => [
                    [
                        'name' => 'Réparation de fractures',
                        'description' => 'Intervention chirurgicale pour consolidation osseuse après fracture.',
                        'price' => 500.00,
                        'duration' => 180,
                        'gap_between_services' => 60,
                    ],
                    [
                        'name' => 'Pose de prothèses (hanche, genou)',
                        'description' => 'Chirurgie spécialisée pour implantation de prothèses articulaires.',
                        'price' => 1500.00,
                        'duration' => 240,
                        'gap_between_services' => 90,
                    ],
                    [
                        'name' => 'Réalignement des membres (ostéotomie corrective)',
                        'description' => 'Réalignement des membres pour corriger les malformations osseuses.',
                        'price' => 1000.00,
                        'duration' => 240,
                        'gap_between_services' => 90,
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
            // 🔹 Étape 1 : Supprimer les relations avec la spécialité "Orthopédie vétérinaire"
            $specialite_id = DB::table('specialites')->where('nom', 'Orthopédie vétérinaire')->value('id');

            if ($specialite_id) {
                DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();
            }

            // 🔹 Étape 2 : Supprimer les services_types créés
            $services_types_ids = DB::table('services_types')
                ->whereIn('libelle', ['Diagnostic orthopédique', 'Chirurgies orthopédiques'])
                ->pluck('id');

            DB::table('services_types')->whereIn('id', $services_types_ids)->delete();

            // 🔹 Étape 3 : Supprimer les services_templates créés
            DB::table('service_templates')
                ->whereIn('name', [
                    'Consultation pour boiteries ou douleurs articulaires',
                    'Tests spécifiques (hanches, genoux, coudes)',
                    'Réparation de fractures',
                    'Pose de prothèses (hanche, genou)',
                    'Réalignement des membres (ostéotomie corrective)',
                ])
                ->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Erreur dans la suppression de la migration : " . $e->getMessage());
        }
    }
}
