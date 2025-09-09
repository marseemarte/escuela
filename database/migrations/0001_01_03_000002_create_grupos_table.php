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
        Schema::create('grupos', function (Blueprint $table) {
            $table->id(); // ID para cada grupo
            $table->integer('nombre'); // Número del grupo (1, 2, 3, etc.) para subdividir cursos grandes
            // Relación con curso - cada grupo pertenece a un curso específico
            $table->foreignId('id_cursos')->constrained('cursos')->onDelete('cascade');
            $table->timestamps();

            // Constraint único para evitar grupos duplicados dentro del mismo curso
            $table->unique(['nombre', 'id_cursos']);
            $table->index('nombre'); // Índice para búsquedas rápidas por número de grupo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
