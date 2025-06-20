<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clinics', function (Blueprint $table) {
            if (!Schema::hasColumn('clinics', 'owner_id')) {
                $table->foreignId('owner_id')
                    ->nullable()
                    ->after('closing_time')
                    ->constrained('users')
                    ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('clinics', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropColumn('owner_id');
        });
    }
};
