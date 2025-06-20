<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\File;
use App\Models\Espece;

class EspeceImageTest extends TestCase
{
    public function test_it_checks_if_espece_images_exist()
    {
        // Récupérer toutes les espèces
        $especes = Espece::all();

        // Vérifier que chaque espèce a bien une image correspondante dans public/img/especes/
        foreach ($especes as $espece) {
            $imagePath = public_path("img/especes/" . lcfirst($espece->nom) . ".png");

            // Assertion que le fichier existe
            $this->assertTrue(
                File::exists($imagePath),
                "L'image pour l'espèce {$espece->nom} est manquante : {$imagePath}"
            );
        }
    }
}
