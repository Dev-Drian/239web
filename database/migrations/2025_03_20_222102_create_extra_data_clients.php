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
        Schema::create('extra_data_clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('owner_name')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('business_fax')->nullable();
            $table->string('photo_url3')->nullable();
            $table->text('directory_list')->nullable();
            $table->text('instructions_notes')->nullable();
            $table->integer('number_of_citations')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_data_clients');
    }
};
