<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animaux', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('espece');
            $table->string('race')->nullable();
            $table->date('date_naissance');
	    $table->integer('age');
            $table->float("poids");
            $table->float('taille');
            $table->foreignId('proprietaire_id')->constrained('users'); // Relation avec users
            $table->text('historique_medical')->nullable();
            $table->text('photo')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animaux');
    }
};
