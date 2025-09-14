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

            // Relaciones
            $table->foreignId('id_horas')->constrained('horas')->onDelete('cascade');
            $table->foreignId('id_salones')->constrained('salones')->onDelete('cascade');
            $table->foreignId('cupof')->constrained('cupof', 'cupof')->onDelete('cascade');

            $table->string('estado', 1)->default('A'); // Estado del horario (A=Activo, I=Inactivo, S=Suspensión temporal)

            $table->timestamps(); // created_at y updated_at para auditoría de horarios
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
