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
        Schema::create('informe_periodo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_asignacionesalumnos')->constrained('asignacionesalumnos')->onDelete('cascade');
            $table->foreignId('cupof')->constrained('cupof', 'cupof')->onDelete('cascade');
            $table->integer('dni_personal');
            $table->date('fecha')->useCurrent();
            $table->string('nota', 4);
            $table->unsignedInteger('periodo');
            $table->foreign('dni_personal')->references('dni')->on('persona')->onDelete('cascade');
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informe_periodo');
    }
};
