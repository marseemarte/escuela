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
            // Cuando se agregue provincias usar la linea de abajo y borrar la de arriba
            //$table->foreignId('id_localidad')->constrained('localidades')->onDelete('cascade');
            $table->integer('pass');
            $table->string('telefono', 40);
            $table->string('mail', 191)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('mail', 191)->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id', 191)->primary();
            $table->foreignId('persona_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persona');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
