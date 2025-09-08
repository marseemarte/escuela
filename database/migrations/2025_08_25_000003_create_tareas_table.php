<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id(); // ID para cada tarea asignada
            $table->string('titulo', 150); // Título descriptivo de la tarea
            $table->mediumText('descripcion'); // Descripción detallada de lo que debe hacer el estudiante
            $table->integer('tamanio'); // Tamaño máximo permitido para archivos de entrega (en bytes)
            $table->string('nombre_archivo', 255); // Nombre del archivo de consigna si lo hay
            $table->string('tipo', 150); // Tipo de archivo permitido para entrega
            $table->date('fecha_subida'); // Fecha en que el docente publicó la tarea
            $table->date('fecha_entrega'); // Fecha límite para entregar la tarea

            // Relación con revista - define qué docente asignó la tarea
            $table->foreignId('id_revista')->constrained('revista')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
