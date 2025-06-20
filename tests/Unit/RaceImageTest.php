<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\File;
use App\Models\Race;

class RaceImageTest extends TestCase
{
    public function test_it_checks_if_race_images_exist()
    {
        // Récupérer toutes les races
        $races = Race::all();

        // Vérifier que chaque race a bien une image correspondante dans public/img/races/
        foreach ($races as $race) {
            $imagePath = public_path("img/races/" . $race->nom . ".png");

            // Assertion que le fichier existe
            $this->assertTrue(
                File::exists($imagePath),
                "L'image pour la race {$race->nom} est manquante : {$imagePath}"
            );
        }
    }
}
