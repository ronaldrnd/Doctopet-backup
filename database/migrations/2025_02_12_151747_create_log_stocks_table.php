<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogStocksTable extends Migration
{
    public function up()
    {
        Schema::create('log_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('actif_id')->constrained('actifs')->onDelete('cascade');
            $table->enum('action', ['add', 'minus']);
            $table->integer('number');
            $table->date('date');
            $table->text('description')->nullable(); // Justification facultative
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_stocks');
    }
}
