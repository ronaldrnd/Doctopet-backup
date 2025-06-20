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
        Schema::create('specialiste_especes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialiste_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('espece_id')->constrained('especes')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialiste_especes');
    }
};
