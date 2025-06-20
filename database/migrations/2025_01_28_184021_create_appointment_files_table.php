<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('appointment_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade'); // Relation avec le rendez-vous
            $table->string('file_name'); // Nom original du fichier
            $table->string('file_path'); // Chemin du fichier stocké
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointment_files');
    }
};
