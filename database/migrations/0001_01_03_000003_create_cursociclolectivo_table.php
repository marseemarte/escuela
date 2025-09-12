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
        Schema::create('cursociclolectivo', function (Blueprint $table) {
            $table->id(); // ID para cada curso en un ciclo lectivo específico

            // Relaciones
            $table->foreignId('id_cursos')->constrained('cursos')->onDelete('cascade');

            $table->year('ciclolectivo'); // Año lectivo específico (2024, 2025, etc.)
            $table->string('estado', 1)->default('A'); // Estado del curso (A=Activo, I=Inactivo, C=Cerrado)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursociclolectivo');
    }
};
