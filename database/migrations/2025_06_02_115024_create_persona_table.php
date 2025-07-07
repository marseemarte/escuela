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
        Schema::create('persona', function (Blueprint $table) {
            $table->id();
            $table->integer('dni');
            $table->string('apellido', 50);
            $table->string('nombre', 50);
            $table->date('fechan');
            $table->string('sexo', 1);
            $table->string('domicilio', 50);
            $table->integer('id_localidad');
            $table->integer('pass');
            $table->string('telefono', 40);
            $table->string('mail', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persona');
    }
};
