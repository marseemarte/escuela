<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('archivos_visto', function (Blueprint $table) {
            $table->id(); // ID para cada registro de visualización
            // Relación con archivo - qué archivo fue visualizado
            $table->foreignId('id_archivo')->constrained('archivos')->onDelete('cascade');
            // Relación con asignación de alumno - quién visualizó el archivo
            $table->foreignId('id_asignacionesalumnos')->constrained('asignacionesalumnos')->onDelete('cascade');

            $table->tinyInteger('visto'); // Estado de visualización (0=No visto, 1=Visto) - coincide con SQL original
            $table->string('tipo', 1); // Tipo de visualización (A=Archivo, T=Tarea, N=Notificación)
            $table->date('fecha'); // Fecha en que se registró la visualización
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archivos_visto');
    }
};
