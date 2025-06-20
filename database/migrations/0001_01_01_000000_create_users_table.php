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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['M', 'F'])->default('M'); // Champ pour le sexe
            $table->string('email')->unique();
            $table->string('phone_number', 20)->nullable(); // Champ pour le numéro de téléphone
            $table->date('birthdate')->nullable(); // Champ pour la date de naissance
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('type', ['C', 'S'])->default('C'); // Champ pour le type (Client ou Spécialiste)
            $table->string('address')->nullable(); // Champ pour l'adresse
            $table->string('profile_picture')->nullable(); // Champ pour la photo de profil
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

