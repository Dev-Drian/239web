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
        Schema::create('client_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('place_id')->nullable();
            $table->string('formatted_address')->nullable();
            $table->string('formatted_phone_number')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->string('street_number')->nullable();
            $table->string('route')->nullable();
            $table->string('gmburl')->nullable();  
            $table->json('weekday_text')->nullable();  
            $table->string('county')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_locations');
    }
};
