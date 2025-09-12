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
        Schema::create('tipopersona', function (Blueprint $table) {
            $table->id(); // ID para cada tipo de persona
            $table->string('tipo', 30); // Descripción del tipo (ej: "Estudiante", "Docente", "Administrativo", "Padre/Tutor")

            $table->string('estado', 1)->default('A'); // Estado del tipo de persona (A=Activo, I=Inactivo)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipopersona');
    }
};
