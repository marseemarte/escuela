<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrientacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orientaciones')->insert([
            [
                'id' => 1,
                'nombre' => 'Programacion',
                'titulo' => 'Técnico en Programación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nombre' => 'Turismo',
                'titulo' => 'Técnico en Turismo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nombre' => 'Construccion',
                'titulo' => 'Maestro Mayor de Obra',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'nombre' => 'Ciclo basico',
                'titulo' => 'Ciclo Básico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
