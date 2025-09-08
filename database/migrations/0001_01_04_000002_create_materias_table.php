<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 70);
            $table->string('abreviatura', 15);
            $table->char('estado', 1)->default('H');
            $table->string('resumen', 50);
            $table->boolean('activo')->default(true);
            $table->foreignId('orientacion_id')->constrained('orientaciones')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materias');
    }
};
