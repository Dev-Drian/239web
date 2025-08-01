<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('google_ads_campaigns', function (Blueprint $table) {
            $table->id();
            
            // Relación con el cliente
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade');

            // Datos básicos de la campaña
            $table->string('campaign_name');
            $table->enum('campaign_type', ['SEARCH'])->default('SEARCH');
            $table->string('status')->default('ENABLED');
            
            // Relación con la cuenta de Google Ads
            $table->unsignedBigInteger('google_account_id');
            $table->string('customer_id');
            $table->string('google_campaign_id')->nullable();
            // Resource names de Google Ads
            $table->string('campaign_resource_name')->nullable();
            $table->string('schedule_resource_name')->nullable();
            $table->string('ad_group_resource_name')->nullable();
            $table->string('budget_resource_name')->nullable();
            $table->string('location_resource_name')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('google_ads_campaigns');
    }
};;
