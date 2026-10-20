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
        Schema::create('permisos_rol', function (Blueprint $table) {
            $table->id('id_permisos_rol');
            $table->foreignId('id_permiso')->constrained('permisos', 'id_permiso')->cascadeOnDelete();
            $table->foreignId('id_rol')->constrained('roles', 'id_rol')->cascadeOnDelete();

            // Decisión técnica: evitar asignaciones duplicadas de un permiso a un rol
            $table->unique(['id_permiso', 'id_rol']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permisos_rol');
    }
};
