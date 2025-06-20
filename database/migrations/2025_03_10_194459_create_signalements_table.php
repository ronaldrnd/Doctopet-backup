<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('signalements', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email');
            $table->string('libelle'); // Titre du signalement
            $table->text('message'); // Contenu du signalement
            $table->boolean('traite')->default(false); // Signalement traité ou non (0 = non traité par défaut)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('signalements');
    }
};
