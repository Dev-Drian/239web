<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Schema::table('google_ads_campaigns', function (Blueprint $table) {
        //     // $table->unsignedBigInteger('google_account_id')->after('client_id');
        //     // $table->string('customer_id')->after('google_account_id');
        //     $table->string('campaign_resource_name')->after('customer_id');
        //     $table->string('schedule_resource_name')->after('campaign_resource_name');
        //     $table->string('ad_group_resource_name')->after('schedule_resource_name');
        //     $table->string('budget_resource_name')->after('ad_group_resource_name');
        //     $table->string('location_resource_name')->after('budget_resource_name');

        //     // $table->foreign('google_account_id')
        //     //     ->references('id')
        //     //     ->on('google_ads_accounts')
        //     //     ->onDelete('cascade');
        // });
    }

    public function down()
    {
        Schema::table('google_ads_campaigns', function (Blueprint $table) {
            $table->dropForeign(['google_account_id']);
            $table->dropColumn([
                'google_account_id',
                'customer_id',
                'campaign_resource_name',
                'schedule_resource_name',
                'ad_group_resource_name',
                'budget_resource_name',
                'location_resource_name'
            ]);
        });
    }
};

