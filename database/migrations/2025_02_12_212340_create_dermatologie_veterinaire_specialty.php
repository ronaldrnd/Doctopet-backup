<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDermatologieVeterinaireSpecialty extends Migration
{
    public function up()
    {
        DB::beginTransaction();


        // Récupérer l'ID de la spécialité "Dermatologie vétérinaire"
        $dermatologie_id = DB::table('specialites')->where('nom', 'Dermatologie vétérinaire')->value('id');


        if (!$dermatologie_id) {
            $dermatologie_id = DB::table('specialites')->insertGetId([
                'nom' => 'Dermatologie vétérinaire',
                'description' => 'Diagnostic et traitement des affections de la peau des animaux.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


// Récupérer les ID des services types à détacher
        $services_to_remove = DB::table('services_types')
            ->whereIn('libelle', ['Imagerie et soins complémentaires', 'Dermatologie'])
            ->pluck('id');

// Supprimer uniquement les liens entre la spécialité et ces services types
        DB::table('specialite_services_types')
            ->where('specialite_id', $dermatologie_id)
            ->whereIn('services_types_id', $services_to_remove)
            ->delete();





        try {
            // Vérifier si la spécialité existe déjà
            $specialite_id = DB::table('specialites')->where('nom', 'Dermatologie vétérinaire')->value('id');

            if (!$specialite_id) {
                // Créer la spécialité si elle n'existe pas
                $specialite_id = DB::table('specialites')->insertGetId([
                    'nom' => 'Dermatologie vétérinaire',
                    'description' => 'Diagnostic et traitement des affections de la peau des animaux.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Création des nouveaux types de services
            $services_types = [
                'Diagnostic et traitement des pathologies cutanées',
                'Soins spécifiques',
            ];

            $services_types_ids = [];
            foreach ($services_types as $libelle) {
                $id = DB::table('services_types')->insertGetId([
                    'libelle' => $libelle,
                    'color_tag' => '#ffffff',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $services_types_ids[$libelle] = $id;
            }




            // Associer les services types à la spécialité
            foreach ($services_types_ids as $service_type_id) {
                DB::table('specialite_services_types')->insert([
                    'specialite_id' => $specialite_id,
                    'services_types_id' => $service_type_id
                ]);
            }

            // Vérifier et associer les services templates existants
            $services_templates = [
                'Diagnostic et traitement des pathologies cutanées' => [
                    'Consultation pour allergies cutanées',
                    'Diagnostic des infections bactériennes ou fongiques',
                    'Détection des parasites externes (puces, tiques, gales)',
                ],
                'Soins spécifiques' => [
                    'Mise en place de traitements dermatologiques (lotions, injections)',
                    'Bains médicaux sous supervision',
                ],
            ];


            $service_template_id = DB::table('service_templates')->insertGetId([
                'name' => 'Consultation pour allergies cutanées',
                'description' => 'Consultation spécialisée pour diagnostiquer et traiter les allergies cutanées chez les animaux.',
                'price' => 80.00,
                'duration' => 45,
                'gap_between_services' => 15,
                'services_types_id' => $services_types_ids["Diagnostic et traitement des pathologies cutanées"], // Assurez-vous que cette variable contient bien l'ID du bon service type
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            $service_template = DB::table('service_templates')->where('name', 'Diagnostic des infections bactériennes ou fongiques')->first();

            if (!$service_template) {
                $service_template_id = DB::table('service_templates')->insertGetId([
                    'name' => 'Diagnostic des infections bactériennes ou fongiques',
                    'description' => 'Examen approfondi pour identifier les infections bactériennes et fongiques de la peau.',
                    'price' => 85.00,
                    'duration' => 50,
                    'gap_between_services' => 15,
                    'services_types_id' => $services_types_ids["Diagnostic et traitement des pathologies cutanées"], // Assurez-vous que cette variable contient bien l'ID du bon service type
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $service_template = DB::table('service_templates')->where('name', 'Détection des parasites externes (puces, tiques, gales)')->first();

            if (!$service_template) {
                $service_template_id = DB::table('service_templates')->insertGetId([
                    'name' => 'Détection des parasites externes (puces, tiques, gales)',
                    'description' => 'Examen dermatologique pour détecter et traiter les infestations parasitaires externes.',
                    'price' => 70.00,
                    'duration' => 40,
                    'gap_between_services' => 10,
                    'services_types_id' => $services_types_ids["Diagnostic et traitement des pathologies cutanées"], // Assurez-vous que cette variable contient bien l'ID du bon service type
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $service_template_id = DB::table('service_templates')->insertGetId([
                'name' => 'Mise en place de traitements dermatologiques (lotions, injections)',
                'description' => 'Application de traitements topiques ou injections pour les affections cutanées.',
                'price' => 90.00,
                'duration' => 60,
                'gap_between_services' => 20,
                'services_types_id' => $services_types_ids["Soins spécifiques"], // Assurez-vous que cette variable contient bien l'ID du bon service type
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $service_template_id = DB::table('service_templates')->insertGetId([
                'name' => 'Bains médicaux sous supervision',
                'description' => 'Séance de bain médicalisé sous surveillance vétérinaire pour apaiser les problèmes dermatologiques.',
                'price' => 100.00,
                'duration' => 60,
                'gap_between_services' => 20,
                'services_types_id' => $services_types_ids["Soins spécifiques"],
                'created_at' => now(),
                'updated_at' => now(),
            ]);








            foreach ($services_templates as $service_type => $templates) {
                foreach ($templates as $template_name) {
                    $template = DB::table('service_templates')->where('name', $template_name)->first();

                    if (!$template) {
                        throw new Exception("Le service template \"$template_name\" est introuvable !");
                    }

                    DB::table('service_templates')->where('id', $template->id)->update([
                        'services_types_id' => $services_types_ids[$service_type]
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

        // Vérifier et associer les services templates existants
        $services_templates = [
            'Diagnostic et traitement des pathologies cutanées' => [
                'Consultation pour allergies cutanées',
                'Diagnostic des infections bactériennes ou fongiques',
                'Détection des parasites externes (puces, tiques, gales)',
            ],
            'Soins spécifiques' => [
                'Mise en place de traitements dermatologiques (lotions, injections)',
                'Bains médicaux sous supervision',
            ],
        ];

        DB::beginTransaction();

        try {
            // Récupérer l'ID de la spécialité
            $specialite_id = DB::table('specialites')->where('nom', 'Dermatologie vétérinaire')->value('id');

            if ($specialite_id) {
                // Supprimer les relations avec les services_types
                DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();

                // Supprimer la spécialité
                DB::table('specialites')->where('id', $specialite_id)->delete();
            }

            // Supprimer les services types créés
            $services_types = [
                'Diagnostic et traitement des pathologies cutanées',
                'Soins spécifiques',
            ];

            foreach ($services_types as $libelle) {
                DB::table('services_types')->where('libelle', $libelle)->delete();
            }

            // Remettre les services templates à NULL
            $templates = array_merge(
                $services_templates['Diagnostic et traitement des pathologies cutanées'],
                $services_templates['Soins spécifiques']
            );

            DB::table('service_templates')->whereIn('name', $templates)->update(['services_types_id' => null]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Erreur lors de la suppression : " . $e->getMessage());
        }
    }
}
