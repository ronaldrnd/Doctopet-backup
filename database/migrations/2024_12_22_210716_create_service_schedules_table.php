<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('service_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id'); // Relation avec la prestation
            $table->string('day_of_week'); // Jour de la semaine (e.g. "Monday")
            $table->time('start_time'); // Heure de début
            $table->time('end_time'); // Heure de fin
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('service_schedules');
    }
};
