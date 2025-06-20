<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVeterinaireChirurgienSpecialty extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Vérifier et créer la spécialité "Chirurgie vétérinaire" si elle n'existe pas
            $specialite_id = DB::table('specialites')->where('nom', 'Chirurgie vétérinaire')->value('id');

            if (!$specialite_id) {
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Chirurgie vétérinaire',
                    'description' => 'Interventions chirurgicales vétérinaires, incluant les chirurgies courantes et spécifiques.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 2 : Supprimer les anciennes relations avec cette spécialité
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

            // 🔹 Étape 3 : Créer ou récupérer les services_types spécifiques à la spécialité
            $services_types = [
                'Chirurgies de routine (Chirurgie vétérinaire)' => '#E67E22', // Orange pour les interventions courantes
                'Chirurgies spécifiques (Chirurgie vétérinaire)' => '#C0392B', // Rouge foncé pour les interventions complexes
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

            // 🔹 Étape 4 : Associer les services_types à la spécialité "Chirurgie vétérinaire"
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
                'Chirurgies de routine (Chirurgie vétérinaire)' => [
                    [
                        'name' => 'Castration chat',
                        'description' => 'Intervention chirurgicale de stérilisation pour chat mâle.',
                        'price' => 70.00,
                        'duration' => 45,
                        'gap_between_services' => 20,
                    ],
                    [
                        'name' => 'Castration chien',
                        'description' => 'Castration pour chien mâle afin de limiter les comportements liés aux hormones.',
                        'price' => 100.00,
                        'duration' => 60,
                        'gap_between_services' => 20,
                    ],
                    [
                        'name' => 'Castration NAC',
                        'description' => 'Castration pour Nouveaux Animaux de Compagnie (lapins, furets, rongeurs).',
                        'price' => 80.00,
                        'duration' => 45,
                        'gap_between_services' => 20,
                    ],
                    [
                        'name' => 'Ovariectomie chienne',
                        'description' => 'Intervention chirurgicale pour stérilisation des chiennes.',
                        'price' => 150.00,
                        'duration' => 90,
                        'gap_between_services' => 30,
                    ],
                    [
                        'name' => 'Ovariectomie chatte',
                        'description' => 'Stérilisation des chattes pour éviter les gestations et chaleurs.',
                        'price' => 90.00,
                        'duration' => 60,
                        'gap_between_services' => 30,
                    ],
                    [
                        'name' => 'Ovariohystérectomie chienne',
                        'description' => 'Stérilisation complète de la chienne, incluant l’ablation de l’utérus.',
                        'price' => 170.00,
                        'duration' => 90,
                        'gap_between_services' => 30,
                    ],
                    [
                        'name' => 'Ovariohystérectomie chatte',
                        'description' => 'Stérilisation complète de la chatte, incluant l’ablation de l’utérus.',
                        'price' => 110.00,
                        'duration' => 60,
                        'gap_between_services' => 30,
                    ],
                ],
                'Chirurgies spécifiques (Chirurgie vétérinaire)' => [
                    [
                        'name' => 'Césarienne chienne',
                        'description' => 'Intervention d’urgence ou programmée pour l’accouchement des chiennes.',
                        'price' => 200.00,
                        'duration' => 120,
                        'gap_between_services' => 45,
                    ],
                    [
                        'name' => 'Césarienne chatte',
                        'description' => 'Opération permettant d’aider une chatte en difficulté lors de la mise bas.',
                        'price' => 180.00,
                        'duration' => 90,
                        'gap_between_services' => 45,
                    ],
                    [
                        'name' => 'Extraction de tumeurs',
                        'description' => 'Chirurgie pour retirer des masses tumorales chez les animaux, nécessitant une analyse en laboratoire.',
                        'price' => 250.00,
                        'duration' => 90,
                        'gap_between_services' => 30,
                    ],
                    [
                        'name' => 'Chirurgies orthopédiques (fractures, luxations)',
                        'description' => 'Réparation des os fracturés, stabilisation des luxations et pose de matériel orthopédique.',
                        'price' => 500.00,
                        'duration' => 180,
                        'gap_between_services' => 60,
                    ],
                    [
                        'name' => 'Détartrage avancé sous anesthésie',
                        'description' => 'Détartrage approfondi des dents sous anesthésie pour prévenir les infections et maladies parodontales.',
                        'price' => 120.00,
                        'duration' => 75,
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
        // 🔹 Supprimer la spécialité et ses services associés
        $specialite_id = DB::table('specialites')->where('nom', 'Chirurgie vétérinaire')->value('id');
        if ($specialite_id) {
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();
        }

        // 🔹 Supprimer les services types et templates associés
        $services_types_ids = DB::table('services_types')
            ->whereIn('libelle', ['Chirurgies de routine (Chirurgie vétérinaire)', 'Chirurgies spécifiques (Chirurgie vétérinaire)'])
            ->pluck('id');

        DB::table('service_templates')->whereIn('services_types_id', $services_types_ids)->delete();
        DB::table('services_types')->whereIn('id', $services_types_ids)->delete();
    }
}
