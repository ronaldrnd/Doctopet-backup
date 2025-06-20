<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Exécute les migrations.
     */
    public function up(): void
    {
        DB::table('specialites')->insert([
            [
                'nom' => 'Médecine interne vétérinaire',
                'description' => 'Diagnostic et prise en charge des maladies chroniques et internes des animaux.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Crématorium animalier',
                'description' => 'Services de crémation pour les animaux, incluant la crémation individuelle et collective.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Annule les migrations.
     */
    public function down(): void
    {
        DB::table('specialites')->whereIn('nom', [
            'Médecine interne vétérinaire',
            'Crématorium animalier'
        ])->delete();
    }
};
