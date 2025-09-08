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
        Schema::create('cursociclolectivo', function (Blueprint $table) {
            $table->id();
            $table->string('estado', 1);
            $table->foreignId('id_cursos')->constrained('cursos')->onDelete('cascade');
            $table->year('ciclolectivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursociclolectivo');
    }
};
