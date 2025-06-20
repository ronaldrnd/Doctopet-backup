<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('races', function (Blueprint $table) {
            $table->id(); // id (bigint unsigned auto_increment primary key)
            $table->string('nom'); // nom (varchar 255)
            $table->foreignId('espece_id') // espece_id (bigint unsigned, foreign key)
            ->constrained('especes') // Référence à la table 'especes'
            ->onDelete('cascade'); // Supprime les races si l'espèce est supprimée
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('races');
    }
};
