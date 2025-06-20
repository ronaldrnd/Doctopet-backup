<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('especes', function (Blueprint $table) {
            $table->string('emoji', 10)->nullable()->after('nom'); // Ajout de l'emoji
        });
    }

    public function down()
    {
        Schema::table('especes', function (Blueprint $table) {
            $table->dropColumn('emoji'); // Suppression si rollback
        });
    }
};
