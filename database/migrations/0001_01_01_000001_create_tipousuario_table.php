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
        Schema::create('tipousuario', function (Blueprint $table) {
            $table->id(); // ID para cada asignación de tipo

            // Relaciones
            $table->foreignId('id_persona')->constrained('persona')->onDelete('cascade');
            $table->foreignId('id_tipopersona')->constrained('tipopersona')->onDelete('cascade');

            $table->string('estado', 1)->default('A'); // Estado del tipo de usuario (A=Activo, I=Inactivo)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipousuario');
    }
};
