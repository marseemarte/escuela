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
        Schema::create('revista', function (Blueprint $table) {
            $table->id(); // ID para cada designación docente
            // Relaciones
            $table->foreignId('cupof')->constrained('cupof', 'cupof')->onDelete('cascade');
            $table->foreignId('id_tipousuario')->constrained('tipousuario')->onDelete('cascade');

            $table->date('fd'); // Fecha desde - inicio de la designación docente
            $table->date('fh'); // Fecha hasta - fin de la designación docente
            $table->integer('secuencia'); // Número de secuencia para ordenar designaciones
            $table->string('situacion', 30); // Situación del docente (titular, suplente, interino)

            $table->string('estado', 1)->default('A'); // Estado de la designación (A=Activo, I=Inactivo, B=Baja)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revista');
    }
};
