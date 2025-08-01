<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('city_excels', function (Blueprint $table) {
            $table->id();
            $table->string('state_code', 10);
            $table->string('state_name', 255);
            $table->string('city', 255);
            $table->string('county', 255)->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('city_excels');
    }
};
