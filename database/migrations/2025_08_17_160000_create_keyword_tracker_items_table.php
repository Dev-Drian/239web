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
        if (!Schema::hasTable('keyword_tracker_items')) {
            Schema::create('keyword_tracker_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('keyword_tracker_id')->constrained('keyword_trackers')->onDelete('cascade');
                $table->string('keyword');
                $table->string('last_position')->nullable();
                $table->string('previous_position')->nullable();
                $table->string('accumulated')->nullable();
                $table->integer('searches')->nullable();
                $table->string('url')->nullable();
                $table->timestamp('last_tracked_at')->nullable();
                $table->timestamps();

                $table->index(['keyword_tracker_id', 'keyword']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keyword_tracker_items');
    }
};


