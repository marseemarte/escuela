<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->string('dia', 3);
            $table->foreignId('id_horas')->constrained('horas')->onDelete('cascade');
            $table->foreignId('id_salones')->constrained('salones')->onDelete('cascade');
            $table->foreignId('cupof')->constrained('cupof', 'cupof')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
