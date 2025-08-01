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
        Schema::create('identity_verifications', function (Blueprint $table) {
            $table->id();

            // Datos principales del documento
            $table->string('doc_first_name', 100)->nullable();
            $table->string('doc_last_name', 100)->nullable();
            $table->string('doc_number', 100)->nullable();
            $table->date('doc_expiry')->nullable();
            $table->string('doc_nationality', 2)->nullable(); // ISO country code

            // Tipo de documento
            $table->enum('doc_type', [
                'ID_CARD',
                'PASSPORT',
                'RESIDENCE_PERMIT',
                'DRIVER_LICENSE',
                'PAN_CARD',
                'AADHAAR',
                'OTHER',
                'VISA',
                'BORDER_CROSSING',
                'ASYLUM',
                'NATIONAL_PASSPORT',
                'PROVISIONAL_DRIVER_LICENSE',
                'VOTER_CARD',
                'OLD_ID_CARD',
                'TRAVEL_CARD',
                'PHOTO_CARD',
                'MILITARY_CARD',
                'PROOF_OF_AGE_CARD',
                'DIPLOMATIC_ID',
                'ADDRESS_CARD',
                'SOCIAL_SECURITY_CARD',
                'WORK_PERMIT'
            ])->nullable();

            // Estado de verificación
            $table->enum('status', [
                'APPROVED',
                'DENIED',
                'SUSPECTED',
                'REVIEWING',
                'EXPIRED',
                'ACTIVE',
                'DELETED',
                'ARCHIVED'
            ])->default('REVIEWING');

            // URLs de archivos
            $table->json('file_urls')->nullable();

            // Información adicional (todo lo demás del JSON original)
            $table->json('more')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identity_verifications');
    }
};
