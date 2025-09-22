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
        Schema::table('materias', function (Blueprint $table) {
            $table->foreignId('orientacion_id')->nullable()->constrained('orientaciones')->onDelete('set null');
            $table->integer('anio')->nullable(); // Año del curso (1-7)
            $table->enum('tipo', ['materia', 'taller'])->default('materia'); // Tipo de contenido
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            $table->dropForeign(['orientacion_id']);
            $table->dropColumn(['orientacion_id', 'anio', 'tipo']);
        });
    }
};
