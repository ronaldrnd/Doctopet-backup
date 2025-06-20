<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspecesEmojiSeeder extends Seeder
{
    public function run()
    {
        $especes = [
            'Chien' => '🐶',
            'Chat' => '🐱',
            'Lapin' => '🐰',
            'Oiseau' => '🐦',
            'Poisson' => '🐠',
        ];

        foreach ($especes as $nom => $emoji) {
            DB::table('especes')->where('nom', $nom)->update(['emoji' => $emoji]);
        }

        $this->command->info('Les emojis ont été ajoutés aux espèces !');
    }
}
