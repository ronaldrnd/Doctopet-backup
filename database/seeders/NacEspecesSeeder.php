<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NacEspecesSeeder extends Seeder
{
    public function run()
    {
        // Liste des espèces avec leurs emojis et races associées
        $especes = [
            [
                'nom' => 'Rongeurs',
                'emoji' => '🐹',
                'races' => ['Hamster doré', 'Hamster russe', 'Hamster roborovski', 'Cochon d’Inde', 'Chinchilla', 'Octodon', 'Rat domestique', 'Souris', 'Gerbille', 'Écureuil de Corée']
            ],
            [
                'nom' => 'Lapin',
                'emoji' => '🐰',
                'races' => ['Lapin nain', 'Lapin bélier', 'Lapin angora', 'Lapin rex', 'Lapin fauve de Bourgogne', 'Lapin géant des Flandres']
            ],
            [
                'nom' => 'Oiseaux',
                'emoji' => '🦜',
                'races' => ['Perroquet gris du Gabon', 'Perruche ondulée', 'Canari', 'Diamant mandarin', 'Inséparable', 'Cacatoès', 'Ara', 'Mainate', 'Toucan']
            ],
            [
                'nom' => 'Reptiles',
                'emoji' => '🦎',
                'races' => ['Iguane vert', 'Pogona (Dragon barbu)', 'Caméléon', 'Python royal', 'Boa constrictor', 'Tortue de Hermann', 'Gecko léopard', 'Serpent des blés', 'Anolis']
            ],
            [
                'nom' => 'Amphibiens',
                'emoji' => '🐸',
                'races' => ['Axolotl', 'Grenouille dendrobate', 'Triton alpestre', 'Crapaud sonneur', 'Salamandre tigrée']
            ],
            [
                'nom' => 'Furets',
                'emoji' => '🦡',
                'races' => ['Furet albinos', 'Furet putoisé', 'Furet zibeline']
            ],
            [
                'nom' => 'Hérissons',
                'emoji' => '🦔',
                'races' => ['Hérisson africain pygmée', 'Hérisson européen']
            ],
            [
                'nom' => 'Poissons',
                'emoji' => '🐠',
                'races' => ['Poisson combattant (Betta)', 'Guppy', 'Molly', 'Platy', 'Poisson rouge', 'Cichlidé africain', 'Discus', 'Arowana', 'Koi']
            ],
            [
                'nom' => 'Insectes & Arachnides',
                'emoji' => '🕷️',
                'races' => ['Phasme bâton', 'Mante religieuse', 'Mygale rose du Chili', 'Scorpion empereur', 'Cétoine dorée']
            ]
        ];

        // Insérer les données dans la table `especes` et `races`
        foreach ($especes as $espece) {
            $especeId = DB::table('especes')->insertGetId([
                'nom' => $espece['nom'],
                'emoji' => $espece['emoji'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            foreach ($espece['races'] as $race) {
                DB::table('races')->insert([
                    'nom' => $race,
                    'espece_id' => $especeId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
