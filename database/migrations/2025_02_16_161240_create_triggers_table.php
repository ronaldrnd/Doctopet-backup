<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('triggers_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actif_id')->constrained('actifs')->onDelete('cascade');
            $table->foreignId('fournisseur_id')->constrained('fournisseurs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('montant');
            $table->integer('ask_montant');
            $table->boolean('is_enable')->default(true);
            $table->enum('trigger_method', ['manual', 'automatic'])->default('manual');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('triggers');
    }
};
