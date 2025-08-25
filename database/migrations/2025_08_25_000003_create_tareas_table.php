<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 150);
            $table->mediumText('descripcion');
            $table->integer('tamanio');
            $table->string('nombre_archivo', 255);
            $table->string('tipo', 150);
            $table->date('fecha_subida');
            $table->date('fecha_entrega');
            $table->unsignedBigInteger('id_revista');
            $table->timestamps();

            $table->foreign('id_revista')->references('id')->on('revistas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};