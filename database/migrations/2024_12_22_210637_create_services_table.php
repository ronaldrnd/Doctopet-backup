<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relation avec le professionnel
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 8, 2); // Prix
            $table->integer('duration'); // Durée en minutes
            $table->integer('gap_between_services')->default(0); // Temps d'attente entre services
            $table->tinyInteger('is_enabled')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('services');
    }
};

