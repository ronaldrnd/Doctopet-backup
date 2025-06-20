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
        Schema::create('dossiers_medicaux', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained('animaux'); // Relation avec animaux
            $table->date('date');
            $table->text('description');
            $table->foreignId('veterinaire_id')->constrained('users'); // Relation avec users
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dossiers_medicaux');

    }
};
