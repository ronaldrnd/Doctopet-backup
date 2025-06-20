<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_ambassador')->default(false); // Indique si l'utilisateur est ambassadeur
            $table->boolean('is_verified')->default(false); // Badge vérifié
            $table->string('referral_code')->unique()->nullable(); // Code de parrainage unique
            $table->foreignId('vouch_receiver_id')->nullable()->constrained('users')->onDelete('set null'); // Qui a reçu un vouch ?
            $table->integer('vouch_amount')->default(0); // Vouch total en euros
        });

        Schema::create('ambassador_access_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Code unique pour l'accès des ambassadeurs
            $table->boolean('used')->default(false); // Vérifier si le code a été utilisé
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_ambassador', 'is_verified', 'referral_code', 'vouch_receiver_id', 'vouch_amount']);
        });

        Schema::dropIfExists('ambassador_access_codes');
    }
};
