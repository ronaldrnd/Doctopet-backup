<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialitesTable extends Migration
{
    public function up()
    {
        Schema::create('specialites', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Nom de la spécialité
            $table->timestamps();
        });

        // Ajouter une relation entre utilisateurs et spécialités
        Schema::create('specialite_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('specialite_id')->constrained('specialites')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('specialite_user');
        Schema::dropIfExists('specialites');
    }
}

