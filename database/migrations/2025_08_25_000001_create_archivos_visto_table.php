<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('archivos_visto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_archivo')->constrained('archivos')->onDelete('cascade');
            $table->foreignId('id_asignacionesalumnos')->constrained('asignacionesalumnos')->onDelete('cascade');

            $table->boolean('visto');
            $table->string('tipo', 1);
            $table->date('fecha');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archivos_visto');
    }
};
