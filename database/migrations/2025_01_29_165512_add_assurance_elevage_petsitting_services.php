<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Récupérer les ID des services types correspondants
        $assurance = DB::table('services_types')->where('libelle', 'Assurance animale')->first();
        $elevage = DB::table('services_types')->where('libelle', 'Élevage')->first();
        $petsitting = DB::table('services_types')->where('libelle', 'Pet-sitting')->first();

        if ($assurance) {
            DB::table('service_templates')->insert([
                // 🏦 Assurance animale
                [
                    'name' => 'Rendez-vous pour devis personnalisé',
                    'description' => 'Prise de rendez-vous avec un conseiller pour établir un devis personnalisé en fonction de votre animal.',
                    'price' => 0.00,
                    'duration' => 30,
                    'gap_between_services' => 15,
                    'services_types_id' => $assurance->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Conseil pour souscription d’un contrat adapté',
                    'description' => 'Entretien avec un expert en assurance pour choisir le meilleur contrat pour votre animal.',
                    'price' => 0.00,
                    'duration' => 30,
                    'gap_between_services' => 15,
                    'services_types_id' => $assurance->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        if ($elevage) {
            DB::table('service_templates')->insert([
                // 🐶 Élevage
                [
                    'name' => 'Rencontre des animaux pour adoption ou achat',
                    'description' => 'Organisez une visite pour rencontrer les animaux avant adoption ou achat.',
                    'price' => 0,
                    'duration' => 30,
                    'gap_between_services' => 10,
                    'services_types_id' => $elevage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Sélection génétique et conseils sur les races',
                    'description' => 'Conseils personnalisés pour choisir la race adaptée à votre mode de vie.',
                    'price' => 50.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $elevage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Préparation des documents administratifs liés à l’adoption',
                    'description' => 'Assistance dans la constitution du dossier pour l’adoption d’un animal.',
                    'price' => 30.00,
                    'duration' => 30,
                    'gap_between_services' => 15,
                    'services_types_id' => $elevage->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        if ($petsitting) {
            DB::table('service_templates')->insert([
                // 🏡 Pet-sitting
                [
                    'name' => 'Réservation d’un rendez-vous avec le pet-sitter',
                    'description' => 'Première rencontre avec le pet-sitter pour organiser la prise en charge de votre animal.',
                    'price' => 20.00,
                    'duration' => 30,
                    'gap_between_services' => 15,
                    'services_types_id' => $petsitting->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Hébergement chez le pet-sitter',
                    'description' => 'Prise en charge complète de votre animal chez le pet-sitter.',
                    'price' => 35.00,
                    'duration' => 1440, // 24h
                    'gap_between_services' => 0,
                    'services_types_id' => $petsitting->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Garde à domicile chez vous',
                    'description' => 'Un pet-sitter s’occupe de votre animal directement chez vous.',
                    'price' => 40.00,
                    'duration' => 1440, // 24h
                    'gap_between_services' => 0,
                    'services_types_id' => $petsitting->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Visites à domicile',
                    'description' => 'Un pet-sitter passe chez vous pour nourrir et surveiller votre animal.',
                    'price' => 25.00,
                    'duration' => 30,
                    'gap_between_services' => 15,
                    'services_types_id' => $petsitting->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Garderie pour chien chez le pet-sitter',
                    'description' => 'Garde temporaire de votre chien dans un cadre sécurisé.',
                    'price' => 30.00,
                    'duration' => 480, // 8h
                    'gap_between_services' => 0,
                    'services_types_id' => $petsitting->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Promenade de chien dans votre quartier',
                    'description' => 'Sortie encadrée pour assurer l’exercice quotidien de votre chien.',
                    'price' => 15.00,
                    'duration' => 60,
                    'gap_between_services' => 15,
                    'services_types_id' => $petsitting->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('service_templates')->whereIn('name', [
            'Rendez-vous pour devis personnalisé',
            'Conseil pour souscription d’un contrat adapté',
            'Rencontre des animaux pour adoption ou achat',
            'Sélection génétique et conseils sur les races',
            'Préparation des documents administratifs liés à l’adoption',
            'Réservation d’un rendez-vous avec le pet-sitter',
            'Hébergement chez le pet-sitter',
            'Garde à domicile chez vous',
            'Visites à domicile',
            'Garderie pour chien chez le pet-sitter',
            'Promenade de chien dans votre quartier',
        ])->delete();
    }
};
