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
        Schema::create('talleres', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 70); // Nombre completo del taller
            $table->string('abreviatura', 15); // Abreviatura para mostrar en horarios
            $table->char('estado', 1)->default('H'); // Estado del taller (H=Habilitado, D=Deshabilitado)
            $table->string('resumen', 50); // Descripción breve del taller
            $table->foreignId('orientacion_id')->nullable()->constrained('orientaciones')->onDelete('set null');
            $table->integer('anio')->nullable(); // Año del curso (1-7)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talleres');
    }
};
