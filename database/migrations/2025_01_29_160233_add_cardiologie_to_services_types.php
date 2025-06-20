<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('services_types')->insert([
            'libelle' => 'Cardiologie',
            'color_tag' => '#C0392B', // Rouge foncé, peut être modifié si besoin
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('services_types')->where('libelle', 'Cardiologie')->delete();
    }
};
