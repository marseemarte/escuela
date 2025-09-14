<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('parentesco', function (Blueprint $table) {
            $table->id(); // ID para cada tipo de parentesco
            $table->string('parentesco', 30); // Tipo de relación familiar (ej: "Padre", "Madre", "Tutor", "Abuelo", "Hermano")

            $table->string('estado', 1)->default('A'); // Estado del parentesco (A=Activo, I=Inactivo)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parentesco');
    }
};
