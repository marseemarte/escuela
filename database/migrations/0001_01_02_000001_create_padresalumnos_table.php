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
            // Relaciones
            $table->foreignId('id_personaalumno')->constrained('persona')->onDelete('cascade');
            $table->foreignId('id_personatutor')->nullable()->constrained('persona')->onDelete('cascade');
            $table->foreignId('id_parentesco')->constrained('parentesco')->onDelete('cascade');

            $table->string('estado', 1)->default('A'); // Estado de la relación (A=Activo, I=Inactivo)

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
