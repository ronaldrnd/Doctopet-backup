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
        Schema::create('urgences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // Relation avec users
            $table->text('description');
            $table->enum('statut', ['open', 'in_progress', 'resolved']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urgences');

    }
};
