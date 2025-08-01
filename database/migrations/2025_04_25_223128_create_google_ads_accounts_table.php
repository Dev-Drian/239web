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
        Schema::create('google_ads_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('customer_id');
            $table->text('refresh_token');
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('currency')->nullable();
            $table->string('timezone')->nullable();
            $table->string('is_mcc')->nullable();
            $table->string('is_subaccount')->nullable();
            $table->string('test_account')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_ads_accounts');
    }
};
