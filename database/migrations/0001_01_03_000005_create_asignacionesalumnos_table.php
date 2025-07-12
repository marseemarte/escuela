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
        Schema::create('asignacionesalumnos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cursosciclolectivo')->constrained('cursociclolectivo')->onDelete('cascade');
            $table->foreignId('id_tipousuario')->constrained('tipousuario')->onDelete('cascade');
            $table->foreignId('id_grupos')->constrained('grupos')->onDelete('cascade');
            $table->string('estado', 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacionesalumnos');
    }
};
