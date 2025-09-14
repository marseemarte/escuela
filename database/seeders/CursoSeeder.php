<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cursos\Curso;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cursos = [
            // Primer año
            ['division' => 'A', 'ano' => 1, 'turno' => 'M'],
            ['division' => 'B', 'ano' => 1, 'turno' => 'M'],
            ['division' => 'C', 'ano' => 1, 'turno' => 'T'],
            ['division' => 'D', 'ano' => 1, 'turno' => 'M'],
            ['division' => 'E', 'ano' => 1, 'turno' => 'M'],
            ['division' => 'F', 'ano' => 1, 'turno' => 'T'],

            // Segundo año
            ['division' => 'A', 'ano' => 2, 'turno' => 'M'],
            ['division' => 'B', 'ano' => 2, 'turno' => 'M'],
            ['division' => 'C', 'ano' => 2, 'turno' => 'T'],
            ['division' => 'D', 'ano' => 2, 'turno' => 'M'],
            ['division' => 'E', 'ano' => 2, 'turno' => 'T'],
            ['division' => 'F', 'ano' => 2, 'turno' => 'M'],

            // Tercer año
            ['division' => 'A', 'ano' => 3, 'turno' => 'M'],
            ['division' => 'B', 'ano' => 3, 'turno' => 'M'],
            ['division' => 'C', 'ano' => 3, 'turno' => 'T'],
            ['division' => 'D', 'ano' => 3, 'turno' => 'M'],
            ['division' => 'E', 'ano' => 3, 'turno' => 'T'],
            ['division' => 'F', 'ano' => 3, 'turno' => 'M'],
        ];

        foreach ($cursos as $curso) {
            Curso::updateOrCreate($curso);
        }
    }
}
