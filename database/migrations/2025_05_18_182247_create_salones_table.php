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
        Schema::create('salones', function (Blueprint $table) {
            $table->increments('id_salones');
            $table->tinyInteger('piso');
            $table->tinyInteger('numero');
            $table->string('tipo', 50);
            $table->integer('capacidad');
            $table->string('corriente', 50);
            $table->string('televisor', 50);
            $table->string('pizarron', 50);
            $table->string('ubicacion', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salones');
    }
};
