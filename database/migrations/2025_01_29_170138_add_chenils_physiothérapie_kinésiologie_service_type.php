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
            ['libelle' => 'Chenils', 'color_tag' => '#D35400', 'created_at' => now(), 'updated_at' => now()],
            ['libelle' => 'Physiothérapie', 'color_tag' => '#16A085', 'created_at' => now(), 'updated_at' => now()],
            ['libelle' => 'Kinésiologie', 'color_tag' => '#F39C12', 'created_at' => now(), 'updated_at' => now()],
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
