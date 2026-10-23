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
        Schema::table('documentos', function (Blueprint $table) {
            $table->string('estado_revision')->default('pendiente_tutor');
            $table->text('observaciones')->nullable();
            $table->timestamp('fecha_dictamen')->nullable();
            $table->string('folio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->dropColumn(['estado_revision', 'observaciones', 'fecha_dictamen', 'folio']);
        });
    }
};
