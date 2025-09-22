<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tareas_notas', function (Blueprint $table) {
            $table->id();

            // Relación con tarea
            $table->foreignId('id_tarea')->constrained('tareas')->onDelete('cascade');

            // Relación con asignación de alumno
            $table->foreignId('id_asignacionesalumnos')->constrained('asignacionesalumnos')->onDelete('cascade');

            $table->string('nota', 4); // Calificación
            $table->string('devolucion', 200)->nullable(); // Comentario del profe

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas_notas');
    }
};


// Eliminar tabla tareas_notas y ejecutar este comando para recrearla con el campo devolucion: 
// php artisan migrate --path=database/migrations/2025_09_21_001952_create_tareas_notas_table.php
// Si no, eliminar la base de datos y ejecutar php artisan migrate para crearla de cero.
