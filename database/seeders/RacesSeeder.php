<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RacesSeeder extends Seeder
{
    public function run()
    {
        // 🔹 Espèces
        $especes = [
            'Chien' => 1,
            'Chat' => 2,
        ];

        // 🔹 Races à ajouter (évite les doublons existants)
        $races = [
            // 🐶 Races de chiens supplémentaires
            ['nom' => 'Australian Cattle Dog', 'espece_id' => $especes['Chien']],
            ['nom' => 'Belgian Sheepdog', 'espece_id' => $especes['Chien']],
            ['nom' => 'Boerboel', 'espece_id' => $especes['Chien']],
            ['nom' => 'Cane Corso', 'espece_id' => $especes['Chien']],
            ['nom' => 'Chesapeake Bay Retriever', 'espece_id' => $especes['Chien']],
            ['nom' => 'Dalmatian', 'espece_id' => $especes['Chien']],
            ['nom' => 'English Springer Spaniel', 'espece_id' => $especes['Chien']],
            ['nom' => 'Jack Russell Terrier', 'espece_id' => $especes['Chien']],
            ['nom' => 'Keeshond', 'espece_id' => $especes['Chien']],
            ['nom' => 'Leonberger', 'espece_id' => $especes['Chien']],
            ['nom' => 'Norwegian Elkhound', 'espece_id' => $especes['Chien']],
            ['nom' => 'Pomeranian', 'espece_id' => $especes['Chien']],
            ['nom' => 'Rhodesian Ridgeback', 'espece_id' => $especes['Chien']],
            ['nom' => 'Schipperke', 'espece_id' => $especes['Chien']],
            ['nom' => 'Staffordshire Bull Terrier', 'espece_id' => $especes['Chien']],
            ['nom' => 'Tibetan Mastiff', 'espece_id' => $especes['Chien']],
            ['nom' => 'Welsh Corgi (Cardigan)', 'espece_id' => $especes['Chien']],
            ['nom' => 'Welsh Corgi (Pembroke)', 'espece_id' => $especes['Chien']],

            // 🐱 Races de chats supplémentaires
            ['nom' => 'Abyssin', 'espece_id' => $especes['Chat']],
            ['nom' => 'American Bobtail', 'espece_id' => $especes['Chat']],
            ['nom' => 'American Curl', 'espece_id' => $especes['Chat']],
            ['nom' => 'American Shorthair', 'espece_id' => $especes['Chat']],
            ['nom' => 'American Wirehair', 'espece_id' => $especes['Chat']],
            ['nom' => 'Balinais', 'espece_id' => $especes['Chat']],
            ['nom' => 'Bengal', 'espece_id' => $especes['Chat']],
            ['nom' => 'Birman', 'espece_id' => $especes['Chat']],
            ['nom' => 'Bombay', 'espece_id' => $especes['Chat']],
            ['nom' => 'British Shorthair', 'espece_id' => $especes['Chat']],
            ['nom' => 'Burmese', 'espece_id' => $especes['Chat']],
            ['nom' => 'Burmilla', 'espece_id' => $especes['Chat']],
            ['nom' => 'Chartreux', 'espece_id' => $especes['Chat']],
            ['nom' => 'Cornish Rex', 'espece_id' => $especes['Chat']],
            ['nom' => 'Devon Rex', 'espece_id' => $especes['Chat']],
            ['nom' => 'Egyptian Mau', 'espece_id' => $especes['Chat']],
            ['nom' => 'Exotic Shorthair', 'espece_id' => $especes['Chat']],
            ['nom' => 'Himalayen', 'espece_id' => $especes['Chat']],
            ['nom' => 'Japanese Bobtail', 'espece_id' => $especes['Chat']],
            ['nom' => 'Korat', 'espece_id' => $especes['Chat']],
            ['nom' => 'LaPerm', 'espece_id' => $especes['Chat']],
            ['nom' => 'Manx', 'espece_id' => $especes['Chat']],
            ['nom' => 'Norwegian Forest Cat', 'espece_id' => $especes['Chat']],
            ['nom' => 'Ocicat', 'espece_id' => $especes['Chat']],
            ['nom' => 'Oriental', 'espece_id' => $especes['Chat']],
            ['nom' => 'Ragamuffin', 'espece_id' => $especes['Chat']],
            ['nom' => 'Ragdoll', 'espece_id' => $especes['Chat']],
            ['nom' => 'Russian Blue', 'espece_id' => $especes['Chat']],
            ['nom' => 'Scottish Fold', 'espece_id' => $especes['Chat']],
            ['nom' => 'Selkirk Rex', 'espece_id' => $especes['Chat']],
            ['nom' => 'Singapura', 'espece_id' => $especes['Chat']],
            ['nom' => 'Snowshoe', 'espece_id' => $especes['Chat']],
            ['nom' => 'Sphynx', 'espece_id' => $especes['Chat']],
            ['nom' => 'Tonkinese', 'espece_id' => $especes['Chat']],
            ['nom' => 'Toyger', 'espece_id' => $especes['Chat']],
            ['nom' => 'Turkish Angora', 'espece_id' => $especes['Chat']],
            ['nom' => 'Turkish Van', 'espece_id' => $especes['Chat']],
        ];

        // 🔹 Insérer uniquement les nouvelles races (évite les doublons)
        foreach ($races as $race) {
            $exists = DB::table('races')
                ->where('nom', $race['nom'])
                ->where('espece_id', $race['espece_id'])
                ->exists();

            if (!$exists) {
                DB::table('races')->insert([
                    'nom' => $race['nom'],
                    'espece_id' => $race['espece_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
