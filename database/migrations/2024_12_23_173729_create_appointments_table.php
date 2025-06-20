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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('animal_id'); // Référence à l'animal
            $table->unsignedBigInteger('specialized_service_id')->nullable();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'canceled'])->default('pending');
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('animal_id')->references('id')->on('animaux')->onDelete('cascade');
            $table->foreign('specialized_service_id')->references('id')->on('specialized_services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
