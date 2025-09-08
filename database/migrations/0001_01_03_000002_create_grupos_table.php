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
            $table->id();
            $table->integer('nombre');
            $table->foreignId('id_cursos')->constrained('cursos')->onDelete('cascade');
            $table->timestamps();

            // Mejorado: Constraint único para evitar grupos duplicados por curso
            $table->unique(['nombre', 'id_cursos']);
            $table->index('nombre');
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
