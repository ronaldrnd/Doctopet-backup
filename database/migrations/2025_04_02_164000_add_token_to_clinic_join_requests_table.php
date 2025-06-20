<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTokenToClinicJoinRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('clinic_join_requests', function (Blueprint $table) {
            $table->uuid('token')->after('status')->unique();
        });
    }

    public function down()
    {
        Schema::table('clinic_join_requests', function (Blueprint $table) {
            $table->dropColumn('token');
        });
    }
}


