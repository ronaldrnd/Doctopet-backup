<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Renommer les spécialités
        DB::table('specialites')
            ->where('nom', 'Toiletteur pour animaux')
            ->update(['nom' => 'Toiletteur']);

        DB::table('specialites')
            ->where('nom', 'Pet-sitter professionnel')
            ->update(['nom' => 'Petsitter']);

        DB::table('specialites')
            ->where('nom', 'Nutritionniste pour animaux')
            ->update(['nom' => 'Nutrisioniste animalier']);

        // Supprimer "Auxiliaire vétérinaire" (singulier)
        DB::table('specialites')
            ->where('nom', 'Auxiliaire vétérinaire')
            ->delete();
    }

    public function down(): void
    {
        // Rollback pour remettre les anciens noms
        DB::table('specialites')
            ->where('nom', 'Toiletteur')
            ->update(['nom' => 'Toiletteur pour animaux']);

        DB::table('specialites')
            ->where('nom', 'Petsitter')
            ->update(['nom' => 'Pet-sitter professionnel']);

        DB::table('specialites')
            ->where('nom', 'Nutrisioniste animalier')
            ->update(['nom' => 'Nutrisionniste pour animaux']);

        // Réinsérer "Auxiliaire vétérinaire" si besoin
        DB::table('specialites')->insert([
            'nom' => 'Auxiliaire vétérinaire',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};
