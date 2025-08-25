<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('archivos_visto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_archivo');
            $table->unsignedBigInteger('id_asignacionesalumnos');
            $table->boolean('visto');
            $table->string('tipo', 1);
            $table->date('fecha');
            $table->timestamps();

            $table->foreign('id_archivo')->references('id')->on('archivos')->onDelete('cascade');
            $table->foreign('id_asignacionesalumnos')->references('id')->on('asignacionesalumnos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archivos_visto');
    }
};