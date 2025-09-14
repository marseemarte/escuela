<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cupof', function (Blueprint $table) {
            $table->id('cupof'); // ID único (CUPOF = Código Único de Posición/Función)
            $table->string('turno', 1); // Turno donde se dicta la materia (M=Mañana, T=Tarde, N=Noche)
            $table->integer('hsmodcar'); // Horas módulo carga - cantidad de horas semanales asignadas

            // Relaciones
            $table->foreignId('id_materias')->constrained('materias')->onDelete('cascade');
            $table->foreignId('id_cursos')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('id_grupos')->constrained('grupos')->onDelete('cascade');

            $table->string('estado', 1); // Estado del CUPOF (A=Activo, I=Inactivo, V=Vacante)

            $table->string('funcion', 4)->default('0'); // Código de función específica
            $table->string('cargo', 5)->default('PF'); // Tipo de cargo (PF=Profesor, etc.)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cupof');
    }
};
