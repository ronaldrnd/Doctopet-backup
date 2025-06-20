<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('specialite_services_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialite_id')->constrained('specialites')->onDelete('cascade');
            $table->foreignId('services_types_id')->constrained('services_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('specialite_services_types');
    }
};
