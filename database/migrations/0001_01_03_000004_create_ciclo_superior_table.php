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
        Schema::create('ciclo_superior', function (Blueprint $table) {
            $table->id(); // ID para cada configuración de ciclo superior
            // Relaciones
            $table->foreignId('id_cursos')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('id_orientaciones')->constrained('orientaciones')->onDelete('cascade');

            $table->string('estado', 1)->default('A'); // Estado de la configuración (A=Activo, I=Inactivo)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciclo_superior');
    }
};
