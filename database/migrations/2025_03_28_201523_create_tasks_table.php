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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('priority', ['low', 'medium', 'high','critical'])->default('low');
            $table->enum('status', ['todo', 'in_progress', 'done'])->default('todo');
            $table->integer('order')->default(0);
            $table->timestamp('due_date')->nullable(); // Nueva columna para fecha límite
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null'); // Asignación de tareas
            $table->unsignedBigInteger('created_by'); // Quién creó la tarea
            $table->softDeletes(); // Borrado suave
            $table->timestamps();
            
            // Índices para mejorar rendimiento
            $table->index(['board_id', 'status']);
            $table->index(['status', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};