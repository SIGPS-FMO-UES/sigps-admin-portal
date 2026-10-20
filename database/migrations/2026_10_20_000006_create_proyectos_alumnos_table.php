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
        Schema::create('proyectos_alumnos', function (Blueprint $table) {
            $table->id('id_proyecto_alumno');
            // Según el diagrama, id_alumno conecta con usuarios.id_usuario (no existe tabla alumnos)
            $table->foreignId('id_alumno')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->foreignId('id_proyecto')->constrained('proyectos', 'id_proyecto')->cascadeOnDelete();

            // Decisión técnica: evitar asociar al mismo alumno al mismo proyecto más de una vez
            $table->unique(['id_alumno', 'id_proyecto']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos_alumnos');
    }
};
