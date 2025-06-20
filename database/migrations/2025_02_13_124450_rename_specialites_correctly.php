<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RenameSpecialitesCorrectly extends Migration
{
    public function up()
    {
        $renamedSpecialites = [
            'Vétérinaire généraliste' => 'Vétérinaire Généraliste',
            'Cardiologie vétérinaire' => 'Vétérinaire Cardiologue',
            'Chirurgie vétérinaire' => 'Vétérinaire Chirurgien',
            'Ophtalmologie vétérinaire' => 'Vétérinaire Ophtalmologue',
            'Orthopédie vétérinaire' => 'Vétérinaire Orthopédiste',
            'Neurologie vétérinaire' => 'Vétérinaire Neurologue',
            'Comportementaliste vétérinaire' => 'Vétérinaire Comportementaliste',
            'Oncologie vétérinaire' => 'Vétérinaire Oncologue',
            'Médecine interne vétérinaire' => 'Vétérinaire en Médecine Interne',
            'Reproduction vétérinaire' => 'Vétérinaire Reproductologue',
            'Soins palliatifs vétérinaires' => 'Vétérinaire en Soins Palliatifs',
            'Vétérinaires spécialisés en imagerie médicale' => 'Vétérinaire en Imagerie Médicale',
            'Dermatologie vétérinaire' => 'Vétérinaire Dermatologue',

            // Autres professionnels
            'Éducateur canin' => 'Éducateur Canin',
            'Ostéopathes animaliers' => 'Ostéopathe Animalier',
            'Physiothérapeute animalier' => 'Physiothérapeute Animalier',
            'Nutritionnistes animaliers' => 'Nutritionniste Animalier',
            'Dentistes animaliers' => 'Dentiste Animalier',
            'Kinésiologues animaliers' => 'Kinésiologue Animalier',
            'Pet sitter' => 'Pet Sitter',
            'Crématorium' => 'Gestionnaire de Crématorium',
        ];

        foreach ($renamedSpecialites as $oldName => $newName) {
            DB::table('specialites')->where('nom', $oldName)->update(['nom' => $newName]);
        }
    }

    public function down()
    {
        $reversedSpecialites = [
            'Vétérinaire Généraliste' => 'Vétérinaire généraliste',
            'Vétérinaire Cardiologue' => 'Cardiologie vétérinaire',
            'Vétérinaire Chirurgien' => 'Chirurgie vétérinaire',
            'Vétérinaire Ophtalmologue' => 'Ophtalmologie vétérinaire',
            'Vétérinaire Orthopédiste' => 'Orthopédie vétérinaire',
            'Vétérinaire Neurologue' => 'Neurologie vétérinaire',
            'Vétérinaire Comportementaliste' => 'Comportementaliste vétérinaire',
            'Vétérinaire Oncologue' => 'Oncologie vétérinaire',
            'Vétérinaire en Médecine Interne' => 'Médecine interne vétérinaire',
            'Vétérinaire Reproductologue' => 'Reproduction vétérinaire',
            'Vétérinaire en Soins Palliatifs' => 'Soins palliatifs vétérinaires',
            'Vétérinaire en Imagerie Médicale' => 'Vétérinaires spécialisés en imagerie médicale',
            'Vétérinaire Dermatologue' => 'Dermatologie vétérinaire',

            // Autres professionnels
            'Éducateur Canin' => 'Éducateur canin',
            'Ostéopathe Animalier' => 'Ostéopathes animaliers',
            'Physiothérapeute Animalier' => 'Physiothérapeute animalier',
            'Nutritionniste Animalier' => 'Nutritionnistes animaliers',
            'Dentiste Animalier' => 'Dentistes animaliers',
            'Kinésiologue Animalier' => 'Kinésiologues animaliers',
            'Conseiller en Assurance Animale' => 'Assurance animale',
            'Pet Sitter' => 'Pet sitter',
            'Gestionnaire de Crématorium' => 'Crématorium',
        ];

        foreach ($reversedSpecialites as $newName => $oldName) {
            DB::table('specialites')->where('nom', $newName)->update(['nom' => $oldName]);
        }
    }
}
