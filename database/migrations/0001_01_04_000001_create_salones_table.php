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
        Schema::create('salones', function (Blueprint $table) {
            $table->id(); // ID para cada salón
            $table->integer('piso'); // Piso donde se encuentra el salón (0=Planta baja, 1=Primer piso, etc.)
            $table->integer('numero'); // Número del salón para identificación física
            $table->string('tipo', 50); // Tipo de salón (ej: "Aula común", "Laboratorio", "Taller", "Gimnasio")
            $table->integer('capacidad'); // Cantidad máxima de estudiantes que puede albergar
            $table->string('corriente', 50); // Información sobre instalación eléctrica disponible
            $table->string('televisor', 50); // Especificaciones del televisor/monitor disponible
            $table->string('pizarron', 50); // Tipo de pizarrón (tradicional, digital, magnético)
            $table->string('ubicacion', 50); // Ubicación específica dentro del edificio
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salones');
    }
};
