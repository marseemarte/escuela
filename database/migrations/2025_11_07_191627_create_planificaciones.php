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
        Schema::create('planificaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('tamanio'); // Tamaño máximo permitido para archivos de planificación (en bytes)
            $table->string('nombre_archivo', 255); // Nombre del archivo de planificación
            $table->string('ruta_archivo', 255); // Ruta donde se almacena el archivo de planificación
            $table->foreignId('id_materia')->constrained('materias')->onDelete('cascade'); // Relación con la tabla materias
            $table->foreignId('id_revista')->constrained('revista')->onDelete('cascade'); // Relación con la tabla revista
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planificaciones');
    }
};
