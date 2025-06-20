<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('elevages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('espece_id')->constrained('especes')->onDelete('cascade');
            $table->foreignId('race_id')->nullable()->constrained('races')->onDelete('cascade');
            $table->integer('age')->comment("Âge de l'animal en mois");
            $table->string('taille')->comment("Taille approximative de l'animal");
            $table->integer('stock')->default(0)->comment("Nombre d'animaux disponibles");
            $table->foreignId('eleveur_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('elevages');
    }
};
