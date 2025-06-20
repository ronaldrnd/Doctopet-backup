<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('accept_online_rdv')->default(true)->after('accept_auto_rdv');
        });
    }

    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('accept_online_rdv');
        });
    }
};

