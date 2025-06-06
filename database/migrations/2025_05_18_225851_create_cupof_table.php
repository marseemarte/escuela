<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cupof', function (Blueprint $table) {
            $table->integer('cupof')->primary();
            $table->string('turno', 1);
            $table->tinyInteger('hsmodcar');
            $table->integer('id_materias');
            $table->integer('id_cursos');
            $table->string('estado', 1);
            $table->string('funcion', 4)->default('0');
            $table->string('cargo', 5)->default('PF');
            $table->tinyInteger('id_grupos');
        });
    }

    public function down(): void {
        Schema::dropIfExists('cupof');
    }
};
