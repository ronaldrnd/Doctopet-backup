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
        DB::table('services_types')->insert([
            ['libelle' => 'Assurance animale', 'color_tag' => '#1ABC9C', 'created_at' => now(), 'updated_at' => now()],
            ['libelle' => 'Élevage', 'color_tag' => '#9B59B6', 'created_at' => now(), 'updated_at' => now()],
            ['libelle' => 'Pet-sitting', 'color_tag' => '#F39C12', 'created_at' => now(), 'updated_at' => now()],
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
