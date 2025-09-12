<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inasistenciasalumnos', function (Blueprint $table) {
            $table->id(); // ID para cada registro de asistencia

            // Relaciones
            $table->foreignId('id_asignacionesalumnos')->constrained('asignacionesalumnos')->onDelete('cascade');
            $table->foreignId('cupof')->constrained('cupof')->onDelete('cascade');
            // CUPOF de la materia donde ocurrió la inasistencia

            $table->date('fecha'); // Fecha específica de la inasistencia
            $table->string('turno', 1); // Turno donde ocurrió (M=Mañana, T=Tarde, N=Noche)
            $table->string('estado', 1)->default('A'); // Estado de la inasistencia (A=Ausente, P=Presente, T=Tardanza)
            $table->string('justificado', 1)->default('0'); // Si está justificada (1=Sí, 0=No)
            $table->integer('dni_personal'); // DNI del personal que registró la asistencia
            $table->timestamps();

            // Constraint único para evitar registros duplicados en la misma fecha/turno
            $table->unique(['id_asignacionesalumnos', 'fecha', 'turno'], 'unique_asistencia_fecha');

            // Índices para mejorar consultas frecuentes
            $table->index(['fecha', 'estado']); // Búsquedas por fecha y estado
            $table->index(['estado', 'justificado']); // Filtros por estado y justificación
            $table->index('dni_personal'); // Búsquedas por quien registró
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inasistenciasalumnos');
    }
};
