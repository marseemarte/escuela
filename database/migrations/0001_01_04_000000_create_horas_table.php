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
        Schema::create('horas', function (Blueprint $table) {
            $table->id(); // ID para cada bloque horario
            $table->string('nombre', 15); // Nombre descriptivo del horario (ej: "1ra hora", "2da hora", "Recreo")
            $table->char('turno', 1); // Turno al que pertenece (M=Mañana, T=Tarde, N=Noche)
            $table->time('hd'); // Hora de inicio del bloque (hora desde)
            $table->time('hh'); // Hora de finalización del bloque (hora hasta)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horas');
    }
};
