<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWarningsTable extends Migration
{
    public function up()
    {
        Schema::create('user_warnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialist_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_target_id')->constrained('users')->onDelete('cascade');
            $table->tinyInteger('level')->default(0);  // Niveau de warning (0,1,2)
            $table->boolean('is_blocked')->default(false);  // Bloqué ou non
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_warnings');
    }
}
