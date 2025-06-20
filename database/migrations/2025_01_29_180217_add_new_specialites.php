<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        DB::table('specialites')->insert([
            [
                'nom' => 'Chenils',
                'description' => 'Hébergement et soins pour animaux sur des périodes courtes ou longues.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Physiothérapeutes animaliers',
                'description' => 'Soins et réhabilitation pour améliorer la mobilité et la récupération des animaux.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Kinésiologues animaliers',
                'description' => 'Équilibre énergétique et gestion du bien-être physique et émotionnel des animaux.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Assurance animale',
                'description' => 'Services de conseil et souscription à des contrats d’assurance pour animaux.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    public function down()
    {
        DB::table('specialites')->whereIn('nom', [
            'Chenils',
            'Physiothérapeutes animaliers',
            'Kinésiologues animaliers',
            'Assurance animale'
        ])->delete();
    }
};
