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
        Schema::create('roles_usuario', function (Blueprint $table) {
            $table->id('id_roles_usuario');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->foreignId('id_rol')->constrained('roles', 'id_rol')->cascadeOnDelete();

            // Decisión técnica: evitar asignaciones duplicadas de un rol al mismo usuario
            $table->unique(['id_usuario', 'id_rol']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_usuario');
    }
};
