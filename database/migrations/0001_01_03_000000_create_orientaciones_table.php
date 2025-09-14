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
        Schema::create('orientaciones', function (Blueprint $table) {
            $table->id(); // ID para cada orientación
            $table->string('nombre'); // Nombre de la orientación (ej: "Ciencias Naturales", "Humanidades", "Economía")
            $table->string('titulo'); // Título que otorga la orientación al graduarse
            $table->string('color', 7)->default('#6B9D7C'); // Color hex para identificación visual en interfaces

            $table->string('estado', 1)->default('A'); // Estado de la orientación (A=Activo, I=Inactivo)

            $table->timestamps();

            // Índice para mejorar el rendimiento en búsquedas por nombre
            $table->index('nombre');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orientaciones');
    }
};
