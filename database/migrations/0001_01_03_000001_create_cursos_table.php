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
            $table->id();
            $table->string('division', 1);
            $table->tinyInteger('ano');
            $table->string('turno', 1);
            $table->timestamps();

            // Índices para mejorar el rendimiento
            $table->index(['ano', 'division']);
            $table->index('turno');

            // Mejorado: Constraint único para evitar duplicados
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
