<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->id(); // ID para cada materia
            $table->string('nombre', 70); // Nombre completo de la materia (ej: "Matemática", "Lengua y Literatura")
            $table->string('abreviatura', 15); // Abreviatura para mostrar en horarios (ej: "MAT", "LYL")
            $table->char('estado', 1)->default('H'); // Estado de la materia (H=Habilitada, D=Deshabilitada)
            $table->string('resumen', 50); // Descripción breve de la materia

            $table->string('estado', 1)->default('A'); // Estado de la materia (A=Activo, I=Inactivo)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materias');
    }
};
