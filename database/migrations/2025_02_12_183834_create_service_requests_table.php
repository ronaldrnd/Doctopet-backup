<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // L'utilisateur qui fait la demande
            $table->string('requested_name');     // Nom du service demandé
            $table->text('description')->nullable();  // Description détaillée
            $table->decimal('suggested_price', 8, 2)->nullable();  // Prix suggéré
            $table->integer('suggested_duration')->nullable();     // Durée suggérée en minutes
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');  // Statut de la demande
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
