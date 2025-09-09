<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tareas_notas', function (Blueprint $table) {
            $table->id(); // ID para cada calificación de tarea

            // Relación con tarea - especifica a qué tarea corresponde esta nota
            $table->foreignId('id_tarea')->constrained('tareas')->onDelete('cascade');

            // Relación con asignación de alumno - identifica a quién se le asigna la nota
            $table->foreignId('id_asignacionesalumnos')->constrained('asignacionesalumnos')->onDelete('cascade');

            $table->string('nota', 4); // Calificación obtenida (ej: "10", "8.5", "A", "D", etc.)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas_notas');
    }
};
