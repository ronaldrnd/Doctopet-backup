<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::table('services_types')->insert([
            ['libelle' => 'Vaccination', 'color_tag' => '#FF5733'],
            ['libelle' => 'Consultation', 'color_tag' => '#33FF57'],
            ['libelle' => 'Chirurgie', 'color_tag' => '#3357FF'],
            ['libelle' => 'Soins', 'color_tag' => '#FF33B5'],
            ['libelle' => 'Toilettage', 'color_tag' => '#FFC300'],
            ['libelle' => 'Imagerie', 'color_tag' => '#2E86C1'],
            ['libelle' => 'Urgence', 'color_tag' => '#E74C3C'],
            ['libelle' => 'Comportemental', 'color_tag' => '#8E44AD'],
            ['libelle' => 'Nutrition', 'color_tag' => '#27AE60'],
            ['libelle' => 'Orthopédie', 'color_tag' => '#D35400'],
            ['libelle' => 'Oncologie', 'color_tag' => '#A93226'],
            ['libelle' => 'Dentisterie', 'color_tag' => '#7D3C98'],
            ['libelle' => 'Médecine interne', 'color_tag' => '#2980B9'],
            ['libelle' => 'Crémation', 'color_tag' => '#2C3E50'],
            ['libelle' => 'Réhabilitation', 'color_tag' => '#16A085'],
            ['libelle' => 'Kinésiologie', 'color_tag' => '#F39C12'],
        ]);
    }

    public function down(): void
    {
        DB::table('services_types')->truncate();
    }
};
