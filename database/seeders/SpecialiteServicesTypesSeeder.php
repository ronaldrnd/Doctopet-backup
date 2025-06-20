<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialiteServicesTypesSeeder extends Seeder
{
    public function run()
    {
        $specialites = DB::table('specialites')->pluck('id', 'nom');
        $servicesTypes = DB::table('services_types')->pluck('id', 'libelle');

        $mappings = [
            'Vétérinaire généraliste' => [
                'Consultation', 'Vaccination', 'Chirurgie', 'Soins', 'Imagerie'
            ],
            'Dermatologie vétérinaire' => [
                'Consultation', 'Soins', 'Dermatologie'
            ],
            'Cardiologie vétérinaire' => [
                'Consultation', 'Imagerie', 'Cardiologie'
            ],
            'Chirurgie vétérinaire' => [
                'Chirurgie', 'Urgence', 'Soins'
            ],
            'Dentisterie vétérinaire' => [
                'Dentisterie', 'Consultation', 'Soins'
            ],
            'Ophtalmologie vétérinaire' => [
                'Consultation', 'Ophtalmologie', 'Soins'
            ],
            'Orthopédie vétérinaire' => [
                'Chirurgie', 'Orthopédie', 'Imagerie'
            ],
            'Neurologie vétérinaire' => [
                'Consultation', 'Neurologie', 'Imagerie'
            ],
            'Comportementaliste vétérinaire' => [
                'Comportemental', 'Éducation comportementale'
            ],
            'Oncologie vétérinaire' => [
                'Consultation', 'Oncologie', 'Imagerie'
            ],
            'Médecine interne vétérinaire' => [
                'Consultation', 'Médecine interne', 'Imagerie'
            ],
            'Réhabilitation et physiothérapie' => [
                'Réhabilitation', 'Physiothérapie'
            ],
            'Toiletteur pour animaux' => [
                'Toilettage', 'Soins'
            ],
            'Pet-sitter professionnel' => [
                'Pet-sitting'
            ],
            'Nutritionniste pour animaux' => [
                'Consultation', 'Nutrition'
            ],
            'Élevage' => [
                'Élevage'
            ],
            'Chenils' => [
                'Chenils'
            ],
            'Assurance animale' => [
                'Assurance animale'
            ],
            'Cliniques d’urgence vétérinaire' => [
                'Urgence', 'Consultation'
            ],
            'Services de sauvetage animalier' => [
                'Urgence', 'Soins'
            ],
            'Crématorium animalier' => [
                'Crémation'
            ],
            'Kinésiologues animaliers' => [
                'Kinésiologie'
            ],
            'Auxiliaires vétérinaires' => [
                'Auxiliaires vétérinaires', 'Consultation', 'Soins'
            ]
        ];

        $insertData = [];

        foreach ($mappings as $specialite => $services) {
            if (!isset($specialites[$specialite])) {
                continue; // Si la spécialité n'existe pas, on l'ignore
            }

            foreach ($services as $serviceType) {
                if (!isset($servicesTypes[$serviceType])) {
                    continue; // Si le service type n'existe pas, on l'ignore
                }

                $insertData[] = [
                    'specialite_id' => $specialites[$specialite],
                    'services_types_id' => $servicesTypes[$serviceType],
                ];
            }
        }

        DB::table('specialite_services_types')->insert($insertData);
    }
}
