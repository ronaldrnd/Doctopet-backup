<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialitesSeeder extends Seeder
{
    public function run()
    {
        $specialites = [
            'Vétérinaire généraliste',
            'Dermatologie vétérinaire',
            'Cardiologie vétérinaire',
            'Chirurgie vétérinaire',
            'Dentisterie vétérinaire',
            'Ophtalmologie vétérinaire',
            'Orthopédie vétérinaire',
            'Neurologie vétérinaire',
            'Comportementaliste vétérinaire',
            'Anesthésiste vétérinaire',
            'Oncologie vétérinaire',
            'Auxiliaire vétérinaire',
            'Toiletteur pour animaux',
            'Soins à domicile',
            'Pet-sitter professionnel',
            'Nutritionniste pour animaux',
            'Réhabilitation et physiothérapie',
            'Vétérinaire équin',
            'Spécialiste NAC',
            'Cliniques d’urgence vétérinaire',
            'Services de sauvetage animalier'
        ];

        foreach ($specialites as $specialite) {
            DB::table('specialites')->insert(['nom' => $specialite, 'created_at' => now(), 'updated_at' => now()]);
        }
    }
}

