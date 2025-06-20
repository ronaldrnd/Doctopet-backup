<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('status', ['pending', 'confirmed', 'canceled', 'completed'])->default('pending')->change();
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('status', ['pending', 'confirmed', 'canceled'])->default('pending')->change();
        });
    }
};
