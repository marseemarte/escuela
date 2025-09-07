<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tareas_notas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tarea')->constrained('tareas')->onDelete('cascade');
            $table->foreignId('id_asignacionesalumnos')->constrained('asignacionesalumnos')->onDelete('cascade');
            $table->string('nota', 4);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas_notas');
    }
};
