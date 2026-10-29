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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id('id_documento');
            $table->string('nombre_documento');
            $table->string('url_documento');
            $table->enum('tipo', [
                'solicitud',
                'inscripcion',
                'anteproyecto',
                'mitad_proyecto',
                'memoria',
                'otro',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
