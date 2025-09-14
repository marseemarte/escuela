<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Esta migración convierte contraseñas numéricas existentes a hash seguro
     */
    public function up(): void
    {
        // Migrar passwords existentes de integer a string hasheado
        // Obtiene todas las personas con contraseñas almacenadas en texto plano
        $personas = DB::table('persona')->get();

        foreach ($personas as $persona) {
            if (is_numeric($persona->pass)) {
                // Convertir password numérico a hash usando bcrypt para seguridad
                // Esto protege las contraseñas contra accesos no autorizados
                DB::table('persona')
                    ->where('id', $persona->id)
                    ->update(['pass' => Hash::make($persona->pass)]);
            }
        }
    }

    /**
     * Reverse the migrations.
     * Revierte los cambios de hash (solo para desarrollo/testing)
     */
    public function down(): void
    {
        // Revertir a passwords numéricos (solo para testing, no recomendado en producción)
        // ADVERTENCIA: Esto compromete la seguridad, usar solo en desarrollo
        DB::table('persona')->update(['pass' => 1234]);
    }
};
