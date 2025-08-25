<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tareas_notas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tarea');
            $table->unsignedBigInteger('id_asignacionesalumnos');
            $table->string('nota', 4);
            $table->timestamps();

            $table->foreign('id_tarea')->references('id')->on('tareas')->onDelete('cascade');
            $table->foreign('id_asignacionesalumnos')->references('id')->on('asignacionesalumnos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas_notas');
    }
};