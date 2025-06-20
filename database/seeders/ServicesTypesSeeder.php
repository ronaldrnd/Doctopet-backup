<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services_types')->insert([
            ['libelle' => 'Vaccination', 'color_tag' => '#FF5733'],
            ['libelle' => 'Consultation', 'color_tag' => '#33FF57'],
            ['libelle' => 'Chirurgie', 'color_tag' => '#3357FF'],
            ['libelle' => 'Soins', 'color_tag' => '#FF33B5'],
            ['libelle' => 'Toilettage', 'color_tag' => '#FFC300'],
            // Ajouter d'autres catégories
        ]);

    }
}
