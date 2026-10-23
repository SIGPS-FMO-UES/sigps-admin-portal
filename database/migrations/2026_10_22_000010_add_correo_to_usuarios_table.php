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
        if (! Schema::hasColumn('usuarios', 'correo')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->string('correo')->nullable()->unique()->after('nombre_completo');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('usuarios', 'correo')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->dropColumn('correo');
            });
        }
    }
};
