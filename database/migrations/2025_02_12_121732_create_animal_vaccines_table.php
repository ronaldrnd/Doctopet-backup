<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalVaccinesTable extends Migration
{
    public function up()
    {
        Schema::create('animal_vaccines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained('animaux')->onDelete('cascade');  // Lien avec la table animaux
            $table->string('vaccine');  // Nom du vaccin
            $table->date('vaccination_date');  // Date du vaccin
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('animal_vaccines');
    }
}
