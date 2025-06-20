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
                'nom' => 'Élevage',
                'description' => 'Élevage et sélection des races pour adoption ou reproduction.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Auxiliaires vétérinaires',
                'description' => 'Assistance en clinique vétérinaire pour soins et gestion des patients.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    public function down()
    {
        DB::table('specialites')->whereIn('nom', ['Élevage', 'Auxiliaires vétérinaires'])->delete();
    }
};
