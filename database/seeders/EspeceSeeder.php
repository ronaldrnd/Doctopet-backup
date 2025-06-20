<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspeceSeeder extends Seeder
{
    public function run()
    {
        $especes = [
            'Chien' => ['Labrador', 'Bulldog', 'Berger Allemand'],
            'Chat' => ['Persan', 'Siamois', 'Maine Coon'],
            'Lapin' => ['Bélier', 'Angora'],
            'Oiseau' => ['Canari', 'Perruche'],
            'Poisson' => ['Betta', 'Guppy'],
        ];

        foreach ($especes as $espece => $races) {
            $especeId = DB::table('especes')->insertGetId(['nom' => $espece]);

            foreach ($races as $race) {
                DB::table('races')->insert([
                    'nom' => $race,
                    'espece_id' => $especeId,
                ]);
            }
        }
    }
}

