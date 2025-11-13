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
        Schema::create('jefe_departamento_materia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_jefe')->constrained('tipousuario')->onDelete('cascade');
            $table->foreignId('id_materia')->constrained('materias')->onDelete('cascade');
            $table->date('fecha_asignacion')->default(now());
            $table->enum('estado', ['A', 'I'])->default('A')->comment('A=Activo, I=Inactivo');
            $table->timestamps();

            // Evitar duplicados
            $table->unique(['id_jefe', 'id_materia']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jefe_departamento_materia');
    }
};
