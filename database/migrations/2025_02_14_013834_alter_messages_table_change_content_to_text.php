<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->text('content')->change(); // Modifier en TEXT
        });
    }

    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->string('content', 255)->change(); // Revenir à VARCHAR(255) en cas de rollback
        });
    }
};
