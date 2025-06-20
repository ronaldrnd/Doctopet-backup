<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RaceDeChienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dogBreeds = [
            'Labrador Retriever',
            'German Shepherd',
            'Golden Retriever',
            'Bulldog',
            'Beagle',
            'Poodle',
            'Rottweiler',
            'Yorkshire Terrier',
            'Boxer',
            'Dachshund',
            'Siberian Husky',
            'Great Dane',
            'Doberman Pinscher',
            'Australian Shepherd',
            'Shih Tzu',
            'Cocker Spaniel',
            'Chihuahua',
            'Pug',
            'Border Collie',
            'Cavalier King Charles Spaniel',
            'Shiba Inu',
            'Akita',
            'Samoyed',
            'Bernese Mountain Dog',
            'Weimaraner',
            'Miniature Schnauzer',
            'English Mastiff',
            'Maltese',
            'French Bulldog',
            'Bull Terrier',
            'Basset Hound',
            'American Eskimo Dog',
            'Collie',
            'Basenji',
            'Irish Setter',
            'Newfoundland',
            'Pointer',
            'Alaskan Malamute',
            'Whippet',
            'Airedale Terrier',
            'Scottish Terrier',
            'Pekingese',
            'Papillon',
            'Bloodhound',
            'Belgian Malinois',
            'Greyhound',
            'Lhasa Apso',
            'Chow Chow',
            'Saint Bernard',
            'Portuguese Water Dog',
        ];

        foreach ($dogBreeds as $breed) {
            DB::table('races')->insert([
                'nom' => $breed,
                'espece_id' => 1, // ID de l'espèce "Chien"
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
