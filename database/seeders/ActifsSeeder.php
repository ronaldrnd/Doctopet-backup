<?php

// database/seeders/ActifsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Actif;

class ActifsSeeder extends Seeder
{
    public function run()
    {
        $actifs = [
            [
                'nom' => 'Amoxicilline',
                'code_ATC' => 'J01CA04',
                'code_CIP' => '3400933255429',
                'type' => 'Boîte',
                'prix' => 15.00,
            ],
            [
                'nom' => 'Metacam (Meloxicam)',
                'code_ATC' => 'M01AC06',
                'code_CIP' => '3400933441549',
                'type' => 'Flacon',
                'prix' => 20.50,
            ],
            [
                'nom' => 'Ivermectine',
                'code_ATC' => 'P54AA05',
                'code_CIP' => '3400935762320',
                'type' => 'Flacon',
                'prix' => 18.00,
            ],
            [
                'nom' => 'Fipronil (Frontline)',
                'code_ATC' => 'P53AX15',
                'code_CIP' => '3400933632480',
                'type' => 'Pipette',
                'prix' => 25.00,
            ],
            [
                'nom' => 'Carprofène',
                'code_ATC' => 'M01AE91',
                'code_CIP' => '3400933821587',
                'type' => 'Comprimés',
                'prix' => 22.00,
            ],
            [
                'nom' => 'Ketamine',
                'code_ATC' => 'N01AX03',
                'code_CIP' => '3400934125967',
                'type' => 'Flacon',
                'prix' => 30.00,
            ],
            [
                'nom' => 'Diazépam',
                'code_ATC' => 'N05BA01',
                'code_CIP' => '3400933531585',
                'type' => 'Flacon',
                'prix' => 28.00,
            ],
            [
                'nom' => 'Clindamycine',
                'code_ATC' => 'J01FF01',
                'code_CIP' => '3400933824564',
                'type' => 'Boîte',
                'prix' => 16.50,
            ],
            [
                'nom' => 'Vaccin contre la rage',
                'code_ATC' => 'J07BG01',
                'code_CIP' => '3400933721481',
                'type' => 'Flacon',
                'prix' => 35.00,
            ],
            [
                'nom' => 'Isoflurane (anesthésique)',
                'code_ATC' => 'N01AB06',
                'code_CIP' => '3400934126574',
                'type' => 'Flacon',
                'prix' => 50.00,
            ],
            [
                'nom' => 'Antiparasitaire Milbemycine',
                'code_ATC' => 'P52AB02',
                'code_CIP' => '3400933601233',
                'type' => 'Comprimés',
                'prix' => 24.00,
            ],
            [
                'nom' => 'Doxycycline',
                'code_ATC' => 'J01AA02',
                'code_CIP' => '3400933834225',
                'type' => 'Boîte',
                'prix' => 19.00,
            ],
            [
                'nom' => 'Vaccin contre la leptospirose',
                'code_ATC' => 'J07AE02',
                'code_CIP' => '3400933721498',
                'type' => 'Flacon',
                'prix' => 32.00,
            ],
            [
                'nom' => 'Anthelminthique Praziquantel',
                'code_ATC' => 'P52AA01',
                'code_CIP' => '3400933601240',
                'type' => 'Comprimés',
                'prix' => 21.00,
            ],
            [
                'nom' => 'Céphalexine',
                'code_ATC' => 'J01DB01',
                'code_CIP' => '3400933255436',
                'type' => 'Boîte',
                'prix' => 17.50,
            ]
        ];

        foreach ($actifs as $actif) {
            Actif::create($actif);
        }
    }
}
