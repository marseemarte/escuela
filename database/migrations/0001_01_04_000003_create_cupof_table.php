<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cupof', function (Blueprint $table) {
            $table->id('cupof');
            $table->string('turno', 1);
            $table->integer('hsmodcar');
            $table->foreignId('id_materias')->constrained('materias')->onDelete('cascade');
            $table->foreignId('id_cursos')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('id_grupos')->constrained('grupos')->onDelete('cascade');
            $table->string('estado', 1);
            $table->string('funcion', 4)->default('0');
            $table->string('cargo', 5)->default('PF');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cupof');
    }
};
