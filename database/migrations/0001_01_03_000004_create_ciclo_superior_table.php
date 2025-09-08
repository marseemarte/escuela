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
            // Relación con curso - define qué cursos pertenecen al ciclo superior
            $table->foreignId('id_cursos')->constrained('cursos')->onDelete('cascade');
            // Relación con orientación - define la especialización del ciclo superior
            $table->foreignId('id_orientaciones')->constrained('orientaciones')->onDelete('cascade');
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
