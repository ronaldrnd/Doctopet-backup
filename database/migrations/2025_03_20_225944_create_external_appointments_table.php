<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('external_appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Le pro qui crée ce rdv
            $table->unsignedBigInteger('service_id')->nullable(); // Optionnel : lien avec un service existant

            $table->string('client_name')->nullable();
            $table->string('animal_name')->nullable();
            $table->string('animal_espece')->nullable();
            $table->string('animal_race')->nullable();

            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('external_appointments');
    }
}
