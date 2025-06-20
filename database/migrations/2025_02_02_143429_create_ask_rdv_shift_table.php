<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ask_rdv_shift', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
            $table->timestamp('decision_at')->nullable();
            $table->timestamps(); // Ajoute created_at et updated_at
            $table->enum('status', ['pending', 'accepted', 'refused'])->default('pending');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ask_rdv_shift');
    }
};
