<?php

namespace Database\Seeders;

use App\Models\Cursos\Curso;
use App\Models\User;
use Database\Seeders\DatosPruebaAsistenciaSeeder2;
use HorariosTest;
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
            DatosPruebaAsistenciaSeeder2::class,
            DatosPruebaPlanificacionSeeder::class,
            ProyectosTestSeeder::class,
            //HorariosTest::class,
        ]);
    }
}
