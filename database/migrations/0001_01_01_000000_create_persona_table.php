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
            $table->id(); // ID para identificar cada persona
            $table->integer('dni')->unique();
            $table->string('apellido', 50); // Apellido de la persona
            $table->string('nombre', 50); // Nombre de la persona
            $table->date('fechan'); // Fecha de nacimiento
            $table->string('sexo', 1); // Sexo de la persona (M/F/X)
            $table->string('domicilio', 50); // Dirección de residencia
            $table->integer('id_localidad'); // ID de la localidad donde reside
            // Cuando se agregue provincias usar la linea de abajo y borrar la de arriba
            //$table->foreignId('id_localidad')->constrained('localidades')->onDelete('cascade'); // Relación con localidades
            $table->string('pass'); // Contraseña hasheada para acceso al sistema
            $table->string('telefono', 40); // Número de teléfono
            $table->string('mail', 191)->unique(); // Email
            $table->timestamp('email_verified_at')->nullable(); // Fecha de verificación del email

            $table->string('estado', 1)->default('A'); // Estado de la persona (A=Activo, I=Inactivo)

            $table->rememberToken(); // Token para "recordar sesión" en login
            $table->timestamps();

            // Índices mejorados
            $table->index(['apellido', 'nombre']); // Búsquedas rápidas por nombre completo
            $table->index('fechan'); // Búsquedas por edad/fecha de nacimiento
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('mail', 191)->primary(); // Email como clave primaria para reset
            $table->string('token'); // Token temporal para reset de contraseña
            $table->timestamp('created_at')->nullable(); // Fecha de creación del token
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id', 191)->primary(); // ID único de la sesión
            $table->foreignId('user_id')->nullable()->index(); // Usuario asociado a la sesión
            $table->string('ip_address', 45)->nullable(); // IP desde donde se conecta
            $table->text('user_agent')->nullable(); // Información del navegador
            $table->longText('payload'); // Datos de la sesión serializados
            $table->integer('last_activity')->index(); // Última actividad para limpieza automática
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
