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
        Schema::create('asignacionesalumnos', function (Blueprint $table) {
            $table->id(); // ID para cada asignación de alumno
            // Relación con curso en ciclo lectivo específico
            $table->foreignId('id_cursosciclolectivo')->constrained('cursociclolectivo')->onDelete('cascade');
            // Relación con tipo de usuario (alumno específico)
            $table->foreignId('id_tipousuario')->constrained('tipousuario')->onDelete('cascade');
            // Relación con grupo específico dentro del curso
            $table->foreignId('id_grupos')->constrained('grupos')->onDelete('cascade');
            $table->string('estado', 1)->default('A'); // Estado de la asignación (A=Activo, I=Inactivo, B=Baja)
            $table->timestamps();

            // Constraint único para evitar asignaciones duplicadas del mismo alumno
            $table->unique(['id_cursosciclolectivo', 'id_tipousuario', 'id_grupos'], 'unique_asignacion');

            // Índices para mejorar consultas frecuentes
            $table->index(['estado']); // Filtros por estado de asignación
            $table->index(['id_cursosciclolectivo', 'estado']); // Consultas por curso y estado
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacionesalumnos');
    }
};
