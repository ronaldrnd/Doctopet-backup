<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('animal_vaccines', function (Blueprint $table) {
            $table->foreignId('added_by_specialist_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->after('animal_id');  // Ajout après l'ID de l'animal
        });
    }

    public function down()
    {
        Schema::table('animal_vaccines', function (Blueprint $table) {
            $table->dropForeign(['added_by_specialist_id']);
            $table->dropColumn('added_by_specialist_id');
        });
    }
};
