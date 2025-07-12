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
        Schema::create('revista', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cupof')->constrained('cupof', 'cupof')->onDelete('cascade');
            $table->foreignId('id_tipousuario')->constrained('tipousuario')->onDelete('cascade');
            $table->date('fd');
            $table->date('fh');
            $table->integer('secuencia');
            $table->string('situacion', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revista');
    }
};
