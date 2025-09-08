<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('archivos', function (Blueprint $table) {
            $table->id(); // ID para cada archivo subido
            $table->string('nombre', 255); // Nombre original del archivo subido
            $table->string('tipo', 100); // Tipo MIME del archivo (ej: "application/pdf", "image/jpeg")
            $table->integer('tamanio'); // Tamaño del archivo en bytes
            $table->string('ruta', 255); // Ruta física donde está almacenado el archivo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};
