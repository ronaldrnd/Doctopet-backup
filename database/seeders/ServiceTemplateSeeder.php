<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceTemplateSeeder extends Seeder
{
    public function run()
    {
        $templates = [
            // Vaccination
            [
                'name' => 'Vaccination chat - Valence rage',
                'description' => 'Vaccination contre la rage pour chats.',
                'price' => 50.00,
                'duration' => 20,
                'gap_between_services' => 10,
                'services_types_id' => 1,
            ],
            [
                'name' => 'Vaccination chien - Valence rage',
                'description' => 'Vaccination contre la rage pour chiens.',
                'price' => 60.00,
                'duration' => 20,
                'gap_between_services' => 10,
                'services_types_id' => 1,
            ],
            [
                'name' => 'Vaccination chien - Valence CHLRPPI',
                'description' => 'Vaccination polyvalente pour chiens contre plusieurs maladies.',
                'price' => 70.00,
                'duration' => 30,
                'gap_between_services' => 15,
                'services_types_id' => 1,
            ],

            // Consultations
            [
                'name' => 'Consultation générale',
                'description' => 'Une consultation vétérinaire pour évaluer la santé générale de votre animal.',
                'price' => 50.00,
                'duration' => 30,
                'gap_between_services' => 10,
                'services_types_id' => 2,
            ],
            [
                'name' => 'Consultation dermatologique',
                'description' => 'Diagnostic des maladies de la peau, allergies et autres pathologies cutanées.',
                'price' => 70.00,
                'duration' => 40,
                'gap_between_services' => 15,
                'services_types_id' => 2,
            ],
            [
                'name' => 'Consultation comportementale',
                'description' => 'Analyse des troubles comportementaux et mise en place de thérapies adaptées.',
                'price' => 80.00,
                'duration' => 45,
                'gap_between_services' => 20,
                'services_types_id' => 2,
            ],

            // Chirurgie
            [
                'name' => 'Castration chat',
                'description' => 'Chirurgie de castration pour chat.',
                'price' => 120.00,
                'duration' => 60,
                'gap_between_services' => 30,
                'services_types_id' => 3,
            ],
            [
                'name' => 'Ovariectomie chienne',
                'description' => 'Chirurgie de stérilisation pour chienne.',
                'price' => 200.00,
                'duration' => 90,
                'gap_between_services' => 30,
                'services_types_id' => 3,
            ],
            [
                'name' => 'Césarienne chienne',
                'description' => 'Chirurgie pour aider à la mise-bas en cas de complications.',
                'price' => 300.00,
                'duration' => 120,
                'gap_between_services' => 45,
                'services_types_id' => 3,
            ],

            // Soins
            [
                'name' => 'Détartrage chien',
                'description' => 'Nettoyage des dents et élimination du tartre pour chien.',
                'price' => 100.00,
                'duration' => 60,
                'gap_between_services' => 20,
                'services_types_id' => 4,
            ],
            [
                'name' => 'Détartrage chat',
                'description' => 'Nettoyage des dents et élimination du tartre pour chat.',
                'price' => 90.00,
                'duration' => 60,
                'gap_between_services' => 20,
                'services_types_id' => 4,
            ],
            [
                'name' => 'Radiographie',
                'description' => 'Imagerie diagnostique pour évaluer les pathologies internes.',
                'price' => 120.00,
                'duration' => 30,
                'gap_between_services' => 15,
                'services_types_id' => 4,
            ],

            // Toilettage
            [
                'name' => 'Bain pour chien',
                'description' => 'Bain et shampooing pour chien.',
                'price' => 40.00,
                'duration' => 30,
                'gap_between_services' => 10,
                'services_types_id' => 5,
            ],
            [
                'name' => 'Coupe des griffes',
                'description' => 'Coupe des griffes pour chats ou chiens.',
                'price' => 20.00,
                'duration' => 15,
                'gap_between_services' => 10,
                'services_types_id' => 5,
            ],
            [
                'name' => 'Démêlage et brushing',
                'description' => 'Soins esthétiques pour le pelage des animaux.',
                'price' => 50.00,
                'duration' => 40,
                'gap_between_services' => 15,
                'services_types_id' => 5,
            ],
        ];

        DB::table('service_templates')->insert($templates);
    }
}
