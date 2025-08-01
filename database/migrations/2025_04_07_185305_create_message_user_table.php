<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('message_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('read_at')->nullable(); // si es null, no lo ha leído
            $table->timestamps();

            $table->unique(['message_id', 'user_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('message_user');
    }
};

