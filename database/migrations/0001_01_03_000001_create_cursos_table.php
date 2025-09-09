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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id(); // ID para cada curso
            $table->string('division', 1); // División del curso (A, B, C, etc.) para diferenciar paralelos
            $table->tinyInteger('ano'); // Año del curso (1, 2, 3, 4, 5, 6) según el nivel educativo
            $table->string('turno', 1); // Turno de clases (M=Mañana, T=Tarde, N=Noche)
            $table->timestamps();

            // Índices para mejorar el rendimiento en consultas frecuentes
            $table->index(['ano', 'division']); // Búsquedas por año y división
            $table->index('turno'); // Filtros por turno

            // Constraint único para evitar duplicados del mismo curso
            $table->unique(['division', 'ano', 'turno']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
