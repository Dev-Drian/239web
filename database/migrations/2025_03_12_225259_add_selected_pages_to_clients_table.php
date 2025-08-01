<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->json('selected_pages')->nullable()->after('remote_page_id')
                ->comment('Stores page IDs and URLs as JSON array');
            $table->json('services')->nullable()->after('name');
            $table->json('areas')->nullable()->after('services');
            $table->json('cars')->nullable()->after('areas');
            $table->json('airports')->nullable()->after('cars');
            $table->string('extra_service')->nullable();

        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('selected_pages');
        });
    }
};
