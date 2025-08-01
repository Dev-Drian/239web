<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('posts')->nullable();
            $table->string('fbsent')->nullable();
            $table->string('prsent')->nullable();
            $table->string('indexed')->nullable();
            $table->string('img')->nullable();
            $table->timestamp('date_created');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade')->nullable(); // Relación con clients
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
