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
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id('id_auditoria');
            $table->foreignId('id_usuario')->nullable()->constrained('usuarios', 'id_usuario')->nullOnDelete();
            $table->string('nombre_usuario', 100)->nullable()->index();
            $table->string('nombre_persona', 200)->nullable();
            $table->string('rol', 80)->nullable()->index();
            $table->string('modulo', 60)->index();
            $table->unsignedBigInteger('id_entidad')->nullable()->index();
            $table->string('tipo_entidad', 60)->nullable();
            $table->string('accion', 60)->index();
            $table->string('titulo', 255);
            $table->text('detalles')->nullable();
            $table->string('estado_anterior', 80)->nullable();
            $table->string('estado_nuevo', 80)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('metadatos')->nullable();
            $table->timestamps();

            $table->index(['created_at', 'rol']);
            $table->index(['modulo', 'id_entidad']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};
