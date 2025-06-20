<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::table('services_types')->insert([
            ['libelle' => 'Éducation comportementale', 'color_tag' => '#8E44AD', 'created_at' => now(), 'updated_at' => now()],
            ['libelle' => 'Ostéopathie', 'color_tag' => '#16A085', 'created_at' => now(), 'updated_at' => now()],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
