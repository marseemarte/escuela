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
        Schema::create('localidades', function (Blueprint $table) {
            $table->id(); // ID  para identificar cada localidad
            $table->string('localidad'); // Nombre de la localidad/ciudad (ej: "Córdoba", "Buenos Aires")
            $table->integer('cp'); // Código postal de la localidad para ubicación geográfica
            $table->string('id_provincias'); // ID de la provincia (temporal como string hasta crear tabla provincias)
            // Cuando se agregue provincias usar la linea de abajo y borrar la de arriba
            //$table->foreignId('id_provincias')->constrained('provincias')->onDelete('cascade'); // Relación con tabla provincias
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localidades');
    }
};
