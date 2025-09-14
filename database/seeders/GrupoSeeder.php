<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cursos\Grupo;
use App\Models\Cursos\Curso;

class GrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cursos = Curso::all();
        $grupoNumber = 101;

        foreach ($cursos as $curso) {
            // Crear 2 grupos por curso (101, 102 para primer curso, 103, 104 para segundo, etc.)
            Grupo::updateOrCreate([
                'nombre' => $grupoNumber,
                'id_cursos' => $curso->id,
            ]);
            $grupoNumber++;

            Grupo::updateOrCreate([
                'nombre' => $grupoNumber,
                'id_cursos' => $curso->id,
            ]);
            $grupoNumber++;
        }
    }
}
