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
        Schema::create('padresalumnos', function (Blueprint $table) {
            $table->id(); // ID para cada relación padre-alumno
            // Relación con el alumno - referencia a la persona que es estudiante
            $table->foreignId('id_personaalumno')->constrained('persona')->onDelete('cascade');
            // Relación con el padre/tutor - puede ser null si no tiene tutor asignado
            $table->foreignId('id_personatutor')->nullable()->constrained('persona')->onDelete('cascade');
            // Tipo de parentesco entre el tutor y el alumno
            $table->foreignId('id_parentesco')->constrained('parentesco')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('padresalumnos');
    }
};
