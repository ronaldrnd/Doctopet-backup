<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Specialite;

class UpdateSpecialitesTable extends Migration
{
    public function up()
    {
        // Renommer les spécialités
        Specialite::where('nom', 'Réhabilitation et physiothérapie')->update(['nom' => 'Ostéopathes animaliers']);
        Specialite::where('nom','Élevage')->update(['nom' => 'Éleveurs']);
        Specialite::where('nom','Crématorium animalier')->update(['nom' => 'Gestionnaire de Crématorium']);



        // Supprimer les relations obsolètes dans la table pivot
        \Illuminate\Support\Facades\DB::table('specialite_services_types')->whereIn('specialite_id', function($query) {
            $query->select('id')
                ->from('specialites')
                ->whereIn('nom', ['Soins à domicile', 'Spécialiste NAC', 'Services de sauvetage animalier']);
        })->delete();



        // Supprimer les spécialités non conservées
        Specialite::whereIn('nom', [
            'Soins à domicile',
            'Spécialiste NAC',
            'Services de sauvetage animalier'
        ])->delete();


    }

    public function down()
    {
        // Revenir aux anciens noms si nécessaire
        Specialite::where('nom', 'Ostéopathes animaliers')->update(['nom' => 'Réhabilitation et physiothérapie']);
        Specialite::where('nom', 'Éleveurs')->update(['nom' => 'Élevage']);
        Specialite::where('nom', 'Gestionnaire de Crématorium')->update(['nom' => 'Crématorium animalier']);

        // Pas de restauration des spécialités supprimées
    }
}
