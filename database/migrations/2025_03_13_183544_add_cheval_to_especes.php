<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChevalToEspeces extends Migration
{
    public function up()
    {
        // Vérifier si l'espèce "Cheval" n'existe pas déjà
        if (!\Illuminate\Support\Facades\DB::table('especes')->where('nom', 'Cheval')->exists()) {
            \Illuminate\Support\Facades\DB::table('especes')->insert([
                'nom' => 'Cheval',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Création de la table des races de chevaux
        Schema::create('races_chevaux', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->unsignedBigInteger('espece_id');
            $table->timestamps();

            $table->foreign('espece_id')->references('id')->on('especes')->onDelete('cascade');
        });

        // Récupérer l'ID de l'espèce "Cheval"
        $chevalEspece = \Illuminate\Support\Facades\DB::table('especes')->where('nom', 'Cheval')->first();

        if ($chevalEspece) {
            // Insérer les différentes races de chevaux
            $races = [
                'Pur-sang',
                'Frison',
                'Quarter Horse',
                'Selle Français',
                'Arabe',
                'Poney Shetland',
                'Shire',
                'Percheron',
                'Appaloosa',
                'Lusitanien',
                'Clydesdale',
                'Mustang'
            ];

            foreach ($races as $race) {
                \Illuminate\Support\Facades\DB::table('races')->insert([
                    'nom' => $race,
                    'espece_id' => $chevalEspece->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down()
    {
        Schema::dropIfExists('races_chevaux');

        // Supprimer l'espèce "Cheval"
        \Illuminate\Support\Facades\DB::table('especes')->where('nom', 'Cheval')->delete();
    }
}
