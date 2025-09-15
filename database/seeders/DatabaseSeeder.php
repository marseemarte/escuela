<?php

namespace Database\Seeders;

use App\Models\Cursos\Curso;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usar el seeder completo de datos de prueba para asistencias
        $this->call([
            DatosPruebaAsistenciaSeeder::class,
        ]);
    }
}
