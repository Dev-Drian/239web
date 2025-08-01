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
        Schema::create('campaign_urls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->text('url');
            $table->string('status')->default('pending');
            $table->timestamp('indexed_at')->nullable();
            $table->timestamps();
            
            $table->index(['campaign_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('campaign_urls');
    }
};
