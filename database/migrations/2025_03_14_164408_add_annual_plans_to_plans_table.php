<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        $annualPlans = [
            ['Vétérinaire Annuel', 'veterinaire-annuel', 'price_1R29MWCZZ9keTINTQPrO1H4z', 57111, 'Abonnement annuel avec 20% d\'économie pour les vétérinaires.'],
            ['Dentiste Annuel', 'dentiste-annuel', 'price_1R29NVCZZ9keTINTkKrU8lKq', 52791, 'Abonnement annuel avec 20% d\'économie pour les dentistes animaliers.'],
            ['Ostéopathe Annuel', 'osteo-annuel', 'price_1R29OJCZZ9keTINTaempB3C7', 47991, 'Abonnement annuel avec 20% d\'économie pour les ostéopathes animaliers.'],
            ['Physiothérapeute Annuel', 'physio-annuel', 'price_1R29P6CZZ9keTINTO52k9vZB', 46071, 'Abonnement annuel avec 20% d\'économie pour les physiothérapeutes animaliers.'],
            ['Kinésiologue Annuel', 'kinesiologue-annuel', 'price_1R29SKCZZ9keTINTUKk4Hakl', 43191, 'Abonnement annuel avec 20% d\'économie pour les kinésiologues animaliers.'],
            ['Naturopathe Annuel', 'naturopathe-annuel', 'price_1R29YBCZZ9keTINT3UfyMja4', 42231, 'Abonnement annuel avec 20% d\'économie pour les naturopathes animaliers.'],
            ['Nutritionniste Annuel', 'nutritionniste-annuel', 'price_1R29TyCZZ9keTINTuLi91C0L', 41271, 'Abonnement annuel avec 20% d\'économie pour les nutritionnistes animaliers.'],
            ['Toiletteur Annuel', 'toiletteur-annuel', 'price_1R29UfCZZ9keTINTgGWY1SkX', 41271, 'Abonnement annuel avec 20% d\'économie pour les toiletteurs animaliers.'],
            ['Chenils Annuel', 'chenil-annuel', 'price_1R29VYCZZ9keTINTigdsxW6u', 28791, 'Abonnement annuel avec 20% d\'économie pour les chenils.'],
            ['Éleveurs Annuel', 'eleveur-annuel', 'price_1R29WCCZZ9keTINTSPQqIUVn', 23991, 'Abonnement annuel avec 20% d\'économie pour les éleveurs spécialisés.'],
            ['Éducateur Canin Annuel', 'educateur-annuel', 'price_1R29WuCZZ9keTINTosfaOewl', 22071, 'Abonnement annuel avec 20% d\'économie pour les éducateurs canins.'],
            ['Petsitter Annuel', 'petsitter-annuel', 'price_1R29XWCZZ9keTINTDAcmrLtr', 19191, 'Abonnement annuel avec 20% d\'économie pour les Pet Sitters.'],
            ['Gestionnaire de Crématorium Mensuel', 'crematorium-mensuel', 'price_1R29bhCZZ9keTINThAsA1BYk', 3999, 'Abonnement mensuel pour les gestionnaires de crématorium.'],
            ['Gestionnaire de Crématorium Annuel', 'crematorium-annuel', 'price_1R29cGCZZ9keTINTdHL3R1cj', 38391, 'Abonnement annuel avec 20% d\'économie pour les gestionnaires de crématorium.'],
        ];

        foreach ($annualPlans as $plan) {
            DB::table('plans')->insert([
                'name' => $plan[0],
                'slug' => $plan[1],
                'stripe_plan' => $plan[2],
                'price' => $plan[3],
                'description' => $plan[4],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down()
    {
        DB::table('plans')->where('slug', 'like', '%annuel%')->delete();
    }
};
