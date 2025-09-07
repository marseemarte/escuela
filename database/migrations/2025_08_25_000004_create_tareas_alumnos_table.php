<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tareas_alumnos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tarea')->constrained('tareas')->onDelete('cascade');
            $table->foreignId('id_asignacionesalumnos')->constrained('asignacionesalumnos')->onDelete('cascade');
            $table->date('fecha');
            $table->string('nombre_archivo', 150);
            $table->tinyInteger('borrado_fisico')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas_alumnos');
    }
};
