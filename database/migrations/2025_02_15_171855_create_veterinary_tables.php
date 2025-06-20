<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Table veto_ext
        Schema::create('veto_ext', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Table cabinet
        Schema::create('cabinet', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('adresse')->nullable();
            $table->string('tel')->nullable();
            $table->timestamps();
        });

        // Table spe_has_cabinet (relation entre veto_ext et cabinet)
        Schema::create('spe_has_cabinet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabinet_id')->constrained('cabinet')->onDelete('cascade');
            $table->foreignId('veto_ext_id')->constrained('veto_ext')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spe_has_cabinet');
        Schema::dropIfExists('cabinet');
        Schema::dropIfExists('veto_ext');
    }
};

