<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inasistenciasalumnos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_asignacionesalumnos')->constrained('asignacionesalumnos')->onDelete('cascade');
            $table->integer('cupof');
            $table->date('fecha');
            $table->string('turno', 1);
            $table->string('estado', 1);
            $table->string('justificado', 1);
            $table->integer('dni_personal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inasistenciasalumnos');
    }
};
