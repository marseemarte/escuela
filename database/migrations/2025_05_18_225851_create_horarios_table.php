<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('horarios', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('dia', 3);
            $table->tinyInteger('id_horas');
            $table->tinyInteger('id_salones');
            $table->integer('cupof');
            $table->foreign('cupof')->references('cupof')->on('cupof')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('horarios');
    }
};
