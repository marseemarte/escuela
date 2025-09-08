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
     */
    public function up(): void
    {
        // Migrar passwords existentes de integer a string hasheado
        $personas = DB::table('persona')->get();

        foreach ($personas as $persona) {
            if (is_numeric($persona->pass)) {
                // Convertir password numérico a hash
                DB::table('persona')
                    ->where('id', $persona->id)
                    ->update(['pass' => Hash::make($persona->pass)]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir a passwords numéricos (solo para testing, no recomendado en producción)
        DB::table('persona')->update(['pass' => 1234]);
    }
};
