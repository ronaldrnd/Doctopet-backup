<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pet_sitter_recurring_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained('animaux')->onDelete('cascade');
            $table->foreignId('specialite_id')->constrained('specialites')->onDelete('cascade');
            $table->foreignId('service_type_id')->constrained('services_types')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID du propriétaire
            $table->string('jour'); // L, M, Mer, J, V, S, D
            $table->time('horaire_debut');
            $table->time('horaire_fin');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pet_sitter_recurring_appointments');
    }
};
