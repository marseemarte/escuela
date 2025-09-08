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
        Schema::create('orientaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('titulo');
            $table->string('color', 7)->default('#6B9D7C');
            $table->timestamps();
            // Índice para mejorar el rendimiento
            $table->index('nombre');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orientaciones');
    }
};
