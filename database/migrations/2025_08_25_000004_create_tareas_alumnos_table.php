<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tareas_alumnos', function (Blueprint $table) {
            $table->id(); // ID para cada entrega de tarea por alumno

            // Relación con tarea - especifica a qué tarea corresponde esta entrega
            $table->foreignId('id_tarea')->constrained('tareas')->onDelete('cascade');

            // Relación con asignación de alumno - identifica quién entregó
            $table->foreignId('id_asignacionesalumnos')->constrained('asignacionesalumnos')->onDelete('cascade');

            $table->date('fecha'); // Fecha en que el alumno entregó la tarea
            $table->string('nombre_archivo', 150); // Nombre del archivo que entregó el estudiante
            $table->tinyInteger('borrado_fisico')->default(0); // Marca para borrado lógico (0=Activo, 1=Eliminado)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas_alumnos');
    }
};
