<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActifsTable extends Migration
{
    public function up()
    {
        Schema::create('actifs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('code_ATC')->nullable();
            $table->string('code_CIP')->nullable();
            $table->string('type'); // Boîte, flacon, etc.
            $table->float('prix');
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('actifs');
    }
}
