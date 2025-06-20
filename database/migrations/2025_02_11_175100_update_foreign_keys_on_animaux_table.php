<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('animaux', function (Blueprint $table) {
            // Supprimer la contrainte existante
            $table->dropForeign(['proprietaire_id']);

            // Ajouter la contrainte avec suppression en cascade
            $table->foreign('proprietaire_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('animaux', function (Blueprint $table) {
            // Supprimer la contrainte en cascade
            $table->dropForeign(['proprietaire_id']);

            // Restaurer la contrainte sans cascade
            $table->foreign('proprietaire_id')
                ->references('id')->on('users');
        });
    }
};
