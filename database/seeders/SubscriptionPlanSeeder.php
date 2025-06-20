<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class SubscriptionPlanSeeder extends Seeder {
    public function run() {
        $plans = [
            [
                'name' => 'Vétérinaire',
                'slug' => 'veterinaire',
                'stripe_plan' => 'price_1Qsvq2CZZ9keTINTTGBnmuMY',
                'price' => 5949, // Prix en centimes (59.49€)
                'description' => 'Abonnement pour les vétérinaires.'
            ],
            [
                'name' => 'Dentiste animalier',
                'slug' => 'dentiste',
                'stripe_plan' => 'price_1QsvqzCZZ9keTINTOIQ7bDyZ',
                'price' => 5499,
                'description' => 'Abonnement pour les dentistes animaliers.'
            ],
            [
                'name' => 'Ostéopathe',
                'slug' => 'osteo',
                'stripe_plan' => 'price_1QsvrKCZZ9keTINTIdIC6Z38',
                'price' => 4999,
                'description' => 'Abonnement pour les ostéopathes animaliers.'
            ],
            [
                'name' => 'Physiothérapeute animalier',
                'slug' => 'physio',
                'stripe_plan' => 'price_1QsvrgCZZ9keTINTFkdIIDFP',
                'price' => 4799,
                'description' => 'Abonnement pour les physiothérapeutes animaliers.'
            ],
            [
                'name' => 'Kinésiologue animalier',
                'slug' => 'kinesiologue',
                'stripe_plan' => 'price_1QsvryCZZ9keTINTmV155R6J',
                'price' => 4499,
                'description' => 'Abonnement pour les kinésiologues animaliers.'
            ],
            [
                'name' => 'Nutritionniste animalier',
                'slug' => 'nutritionniste',
                'stripe_plan' => 'price_1QsvsJCZZ9keTINTSltW1UPn',
                'price' => 4299,
                'description' => 'Abonnement pour les nutritionnistes animaliers.'
            ],
            [
                'name' => 'Toiletteur',
                'slug' => 'toiletteur',
                'stripe_plan' => 'price_1QsvsdCZZ9keTINTEXY9y73j',
                'price' => 4299,
                'description' => 'Abonnement pour les toiletteurs animaliers.'
            ],
            [
                'name' => 'Chenil',
                'slug' => 'chenil',
                'stripe_plan' => 'price_1QsvsuCZZ9keTINTWwqRbkkr',
                'price' => 2999,
                'description' => 'Abonnement pour les chenils.'
            ],
            [
                'name' => 'Éleveur spécialisé',
                'slug' => 'eleveur',
                'stripe_plan' => 'price_1QsvtECZZ9keTINTE6L7eNPs',
                'price' => 2499,
                'description' => 'Abonnement pour les éleveurs spécialisés.'
            ],
            [
                'name' => 'Éducateur canin',
                'slug' => 'educateur',
                'stripe_plan' => 'price_1QsvtdCZZ9keTINTUUo7pmUw',
                'price' => 2299,
                'description' => 'Abonnement pour les éducateurs canins.'
            ],
            [
                'name' => 'Pet Sitter',
                'slug' => 'petsitter',
                'stripe_plan' => 'price_1QsvtzCZZ9keTINTy3ABPZzQ',
                'price' => 1999,
                'description' => 'Abonnement pour les Pet Sitters.'
            ],
            [
                'name' => 'Test',
                'slug' => 'test',
                'stripe_plan' => 'price_1Qw6BVCZZ9keTINTLTjNPik7',
                'price' => 0010,
                'description' => 'Abonnement Test.'
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
