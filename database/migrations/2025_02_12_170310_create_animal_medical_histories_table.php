<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalMedicalHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('animal_medical_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained('animaux')->onDelete('cascade');
            $table->foreignId('specialist_id')->constrained('users')->onDelete('cascade');
            $table->text('modification'); // Contient la description de la modification
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('animal_medical_histories');
    }
}
