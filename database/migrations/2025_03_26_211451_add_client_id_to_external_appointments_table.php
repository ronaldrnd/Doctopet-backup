<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientIdToExternalAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::table('external_appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable()->after('user_id');

            $table->foreign('client_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete(); // ou ->cascadeOnDelete() si tu veux tout supprimer avec
        });
    }

    public function down()
    {
        Schema::table('external_appointments', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }
}
