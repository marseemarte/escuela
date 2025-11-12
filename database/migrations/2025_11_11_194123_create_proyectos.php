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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->integer('tamanio'); // Tamaño máximo permitido para archivos del proyecto (en bytes)
            $table->string('nombre_archivo', 255); // Nombre del archivo del proyecto
            $table->string('ruta_archivo', 255); // Ruta donde se almacena el archivo del proyecto
            $table->foreignId('id_revista')->constrained('revista')->onDelete('cascade'); // Relación con el profesor que sube el proyecto
            $table->foreignId('cupof')->constrained('cupof', 'cupof')->onDelete('cascade'); // Relación con el curso/materia
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
