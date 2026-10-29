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
        Schema::create('documentos_proyecto', function (Blueprint $table) {
            $table->id('id_documento_proyecto');
            $table->foreignId('id_proyecto')->constrained('proyectos', 'id_proyecto')->cascadeOnDelete();
            $table->foreignId('id_documento')->constrained('documentos', 'id_documento')->cascadeOnDelete();

            // Decisión técnica: evitar asociar el mismo documento al mismo proyecto más de una vez
            $table->unique(['id_proyecto', 'id_documento']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_proyecto');
    }
};
