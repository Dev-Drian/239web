<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained()->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->text('content')->nullable(); // Contenido del mensaje (texto)
            $table->enum('message_type', ['text', 'image', 'video', 'document', 'audio'])->default('text');
            $table->string('file_path')->nullable(); // Ruta del archivo en el sistema
            $table->string('file_name')->nullable(); // Nombre original del archivo
            $table->string('file_size')->nullable(); // Tamaño del archivo (ej. "2.5 MB")
            $table->string('file_extension')->nullable(); // Extensión (ej. "pdf", "jpg")
            $table->string('file_mime_type')->nullable(); // Tipo MIME (ej. "image/jpeg")
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
