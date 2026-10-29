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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id('id_proyecto');
            $table->string('nombre_proyecto');
            $table->integer('codigo_proyecto')->unique();
            $table->enum('estado', [
                'solicitado',
                'en_inscripcion',
                'en_proceso',
                'en_finalizacion',
                'finalizado',
            ]);
            // Decisión técnica: tutor_id nullable hacia usuarios(id_usuario) con nullOnDelete
            // (Pendiente de confirmación según especificación si tutor_id referencia usuarios.id_usuario)
            $table->foreignId('tutor_id')->nullable()->constrained('usuarios', 'id_usuario')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
