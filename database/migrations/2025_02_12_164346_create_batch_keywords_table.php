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
        Schema::create('batch_keywords', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained('batches')->onDelete('cascade'); // Relación correcta con batches
            $table->string('keyword');
            $table->string('position')->nullable();
            $table->string('search_volume')->nullable();
            $table->string('url')->nullable();
            $table->string('cpc')->nullable(); // Mejor usar decimal para valores monetarios
            $table->date('date')->nullable();
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('cascade'); // Relación con clients
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_keywords');
    }
};
