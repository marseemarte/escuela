<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id(); // ID para cada horario asignado
            $table->string('dia', 3); // Día de la semana (LUN, MAR, MIE, JUE, VIE, SAB)
            // Relación con bloque horario específico
            $table->foreignId('id_horas')->constrained('horas')->onDelete('cascade');
            // Relación con salón donde se dicta la clase
            $table->foreignId('id_salones')->constrained('salones')->onDelete('cascade');
            // Relación con CUPOF (materia-curso-grupo específico)
            $table->foreignId('cupof')->constrained('cupof', 'cupof')->onDelete('cascade');
            $table->timestamps(); // created_at y updated_at para auditoría de horarios
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
