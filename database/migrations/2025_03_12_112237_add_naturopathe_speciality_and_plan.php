<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        DB::transaction(function () {
            // 1️⃣ Ajouter la spécialité "Naturopathe"
            $specialityId = DB::table('specialites')->insertGetId([
                'nom' => 'Naturopathe',
                'description' => 'Médecine naturelle et soins holistiques pour animaux.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2️⃣ Ajouter le plan "Naturopathe" dans `plans`
            $planId = DB::table('plans')->insertGetId([
                'name' => 'Naturopathe',
                'slug' => 'naturopathe',
                'stripe_plan' => 'price_1R1TzsCZZ9keTINTU2ai5Rs7',
                'price' => 4399, // Prix en centimes (€43.99)
                'description' => 'Abonnement pour les naturopathes animaliers.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 3️⃣ Associer le plan à la spécialité (si une table pivot existe)
            if (Schema::hasTable('plan_specialite')) {
                DB::table('plan_specialite')->insert([
                    'plan_id' => $planId,
                    'specialite_id' => $specialityId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }

    public function down()
    {
        DB::transaction(function () {
            // Supprimer la spécialité
            DB::table('specialites')->where('nom', 'Naturopathe')->delete();
            // Supprimer le plan
            DB::table('plans')->where('slug', 'naturopathe')->delete();
            // Supprimer l'association (si existante)
            DB::table('plan_specialite')->where('specialite_id', function ($query) {
                $query->select('id')->from('specialites')->where('nom', 'Naturopathe');
            })->delete();
        });
    }
};
