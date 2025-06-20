<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('specialized_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id'); // Clé étrangère vers `services`
            $table->string('name'); // Nom de la formule spécialisée
            $table->decimal('price', 8, 2); // Prix de la formule
            $table->integer('duration'); // Durée en minutes
            $table->string('size')->nullable(); // Taille de l'animal (e.g., Small, Medium, Large)
            $table->decimal('min_weight', 5, 2)->nullable(); // Poids minimum (kg)
            $table->decimal('max_weight', 5, 2)->nullable(); // Poids maximum (kg)
            $table->integer('min_height')->nullable(); // Taille minimum (cm)
            $table->integer('max_height')->nullable(); // Taille maximum (cm)
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialized_services');
    }
};
