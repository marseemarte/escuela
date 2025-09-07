<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('tipo', 100);
            $table->integer('tamanio');
            $table->string('ruta', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};
