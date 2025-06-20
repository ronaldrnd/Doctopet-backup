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
                'libelle' => 'Neurologie',
                'color_tag' => '#5D6D7E', // Gris-bleu
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
        DB::table('services_types')->whereIn('libelle', ['Neurologie'])->delete();
    }
};
