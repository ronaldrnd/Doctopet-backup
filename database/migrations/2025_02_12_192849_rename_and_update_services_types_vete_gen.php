<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Récupérer ou créer la spécialité "Vétérinaire généraliste"
            $specialite_id = DB::table('specialites')->where('nom', 'Vétérinaire généraliste')->value('id');

            if (!$specialite_id) {
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Vétérinaire généraliste',
                    'description' => 'Soins vétérinaires généraux pour animaux de compagnie et fermiers.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 🔹 Étape 2 : Supprimer les relations existantes avec cette spécialité
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

            // 🔹 Étape 3 : Créer ou récupérer les services_types spécifiques
            $services_types = [
                'Consultations classique' => '#33FF57',
                'Consultations vaccinales' => '#33FF57',
                'Euthanasie' => '#E74C3C',
                'Chirurgie' => '#3357FF',
                'Imagerie et soins complémentaires' => '#2E86C1',
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

            // 🔹 Étape 4 : Associer les services_types à la spécialité "Vétérinaire généraliste"
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
                'Consultations vaccinales' => [
                    'Consultation vaccinale chat - Valence rage',
                    'Consultation vaccinale chat - Valence FeLV',
                    'Consultation vaccinale chat - Valence HCPL',
                    'Consultation vaccinale chien - Valence rage',
                    'Consultation vaccinale chien - Valence CHLRPPI',
                    'Consultation vaccinale chien - Valence LR',
                    'Consultation vaccinale chien - Valence CHPPI',
                    'Vaccination HCPL pour chat / CHRPPI/CHPPI pour chien',
                ],
                'Euthanasie' => [
                    'Euthanasie chat',
                    'Euthanasie chien',
                ],
                'Chirurgie' => [
                    'Castration chat',
                    'Castration chien',
                    'Castration NAC',
                    'Ovariectomie chienne',
                    'Ovariectomie chatte',
                    'Ovariohystérectomie chienne',
                    'Ovariohystérectomie chatte',
                    'Césarienne chienne',
                    'Césarienne chatte',
                    'Détartrage chien',
                    'Détartrage chat',
                    'Avortement chienne (2 injections)',
                    'Identification électronique (puce)',
                ],
                'Imagerie et soins complémentaires' => [
                    'Radiographie (par cliché)',
                ],
                'Consultations classique' => [
                    'Consultation',
                    'Visite de routine',
                ]
            ];

            foreach ($services_templates as $service_type => $templates) {
                foreach ($templates as $template) {
                    // Vérifier si le service template existe déjà
                    $existing_template = DB::table('service_templates')->where('name', $template)->first();

                    // S'il existe, on le supprime avant de le recréer
                    if ($existing_template) {
                        DB::table('service_templates')->where('id', $existing_template->id)->delete();
                    }

                    // Insérer le service template avec l'ID correct du service type
                    DB::table('service_templates')->insert([
                        'name' => $template,
                        'description' => "Service vétérinaire : " . $template,
                        'price' => 60.00,
                        'duration' => 45,
                        'gap_between_services' => 15,
                        'services_types_id' => $services_types_ids[$service_type],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
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
        // 🔹 Étape 1 : Récupérer les IDs des services types à supprimer
        $services_types_ids = DB::table('services_types')
            ->whereIn('libelle', ['Consultations vaccinales', 'Euthanasie', 'Chirurgie', 'Imagerie et soins complémentaires'])
            ->pluck('id');

        // 🔹 Étape 2 : Supprimer les liens avec `specialite_services_types`
        DB::table('specialite_services_types')
            ->whereIn('services_types_id', $services_types_ids)
            ->delete();

        // 🔹 Étape 3 : Supprimer les services templates associés
        DB::table('service_templates')
            ->whereIn('services_types_id', $services_types_ids)
            ->delete();

        // 🔹 Étape 4 : Supprimer les services types eux-mêmes
        DB::table('services_types')
            ->whereIn('id', $services_types_ids)
            ->delete();

        // 🔹 Étape 5 : Supprimer la spécialité "Vétérinaire généraliste"
        DB::table('specialites')->where('nom', 'Vétérinaire généraliste')->delete();
    }
};
