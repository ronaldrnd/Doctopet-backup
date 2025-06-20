<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('services_types')->insert([
            [
                'libelle' => 'Ophtalmologie',
                'color_tag' => '#1F618D', // Bleu foncé
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('services_types')->where('libelle', 'Ophtalmologie')->delete();
    }
};

