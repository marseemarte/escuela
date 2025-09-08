<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inasistenciasalumnos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_asignacionesalumnos')->constrained('asignacionesalumnos')->onDelete('cascade');
            $table->integer('cupof');
            $table->date('fecha');
            $table->string('turno', 1);
            $table->string('estado', 1)->default('A'); // Mejorado: valor por defecto
            $table->string('justificado', 1)->default('0'); // Mejorado: valor por defecto
            $table->integer('dni_personal');
            $table->timestamps();

            // Mejorado: Constraint único para evitar registros duplicados
            $table->unique(['id_asignacionesalumnos', 'fecha', 'turno'], 'unique_asistencia_fecha');

            // Índices para mejorar consultas
            $table->index(['fecha', 'estado']);
            $table->index(['estado', 'justificado']);
            $table->index('dni_personal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inasistenciasalumnos');
    }
};
