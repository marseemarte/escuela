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
        Schema::create('ciclo_superior', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cursos')
                ->references('id')
                ->on('cursos')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('id_orientaciones')
                ->references('id')
                ->on('orientaciones')
                ->constrained()
                ->onDelete('cascade');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciclo_superior');
    }
};
