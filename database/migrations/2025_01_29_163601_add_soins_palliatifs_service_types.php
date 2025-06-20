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
                'libelle' => 'Soins palliatifs',
                'color_tag' => '#E67E22', // Orange foncé
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('services_types')->whereIn('libelle', ['Soins palliatifs'])->delete();
    }
};
