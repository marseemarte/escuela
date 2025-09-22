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
        Schema::table('cupof', function (Blueprint $table) {
            // Hacer nullable el campo id_grupos
            $table->foreignId('id_grupos')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cupof', function (Blueprint $table) {
            // Revertir el campo id_grupos a no nullable
            $table->foreignId('id_grupos')->nullable(false)->change();
        });
    }
};
