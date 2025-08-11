<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MateriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Materias para Programación (ID: 1)
        $materiasProgramacion = [
            [4, 'Sistemas Digitales', 'Introducción a los sistemas digitales y lógica booleana'],
            [4, 'Matemática', 'Matemática aplicada a la programación'],
            [5, 'Hardware', 'Estudio de componentes físicos de computadoras'],
            [5, 'Programación I', 'Fundamentos de programación'],
            [6, 'Redes', 'Conceptos básicos de redes informáticas'],
            [6, 'Programación II', 'Programación orientada a objetos'],
            [7, 'Base de Datos', 'Diseño y administración de bases de datos'],
            [7, 'Proyecto Final', 'Desarrollo de aplicación completa'],
        ];

        foreach ($materiasProgramacion as $materia) {
            DB::table('materias')->insert([
                'nombre' => $materia[1],
                'abreviatura' => substr($materia[1], 0, 3),
                'estado' => 'H',
                'resumen' => $materia[2],
                'tipo' => 'materia',
                'anio' => $materia[0],
                'orientacion_id' => 1,
                'curso_id' => DB::table('cursos')->where('ano', $materia[0])->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Talleres para Programación
        $talleresProgramacion = [
            [4, 'Taller de Informática', 'Uso básico de computadoras y software'],
            [5, 'Taller de Hardware', 'Armado y reparación de PCs'],
            [6, 'Taller de Redes', 'Instalación y configuración de redes'],
            [7, 'Taller de Programación', 'Desarrollo de aplicaciones prácticas'],
        ];

        foreach ($talleresProgramacion as $taller) {
            DB::table('materias')->insert([
                'nombre' => $taller[1],
                'abreviatura' => substr($taller[1], 0, 3),
                'estado' => 'H',
                'resumen' => $taller[2],
                'tipo' => 'taller',
                'anio' => $taller[0],
                'orientacion_id' => 1,
                'curso_id' => DB::table('cursos')->where('ano', $taller[0])->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Materias para Turismo (ID: 2)
        $materiasTurismo = [
            [4, 'Geografía Turística', 'Estudio de destinos turísticos'],
            [5, 'Historia del Turismo', 'Evolución del turismo mundial'],
            [6, 'Marketing Turístico', 'Estrategias de promoción turística'],
            [7, 'Gestión Hotelera', 'Administración de establecimientos hoteleros'],
        ];

        foreach ($materiasTurismo as $materia) {
            DB::table('materias')->insert([
                'nombre' => $materia[1],
                'abreviatura' => substr($materia[1], 0, 3),
                'estado' => 'H',
                'resumen' => $materia[2],
                'tipo' => 'materia',
                'anio' => $materia[0],
                'orientacion_id' => 2,
                'curso_id' => DB::table('cursos')->where('ano', $materia[0])->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Materias para Construcción (ID: 3)
        $materiasConstruccion = [
            [4, 'Dibujo Técnico', 'Fundamentos del dibujo técnico'],
            [5, 'Materiales de Construcción', 'Estudio de materiales'],
            [6, 'Estructuras', 'Cálculo de estructuras básicas'],
            [7, 'Instalaciones', 'Instalaciones eléctricas y sanitarias'],
        ];

        foreach ($materiasConstruccion as $materia) {
            DB::table('materias')->insert([
                'nombre' => $materia[1],
                'abreviatura' => substr($materia[1], 0, 3),
                'estado' => 'H',
                'resumen' => $materia[2],
                'tipo' => 'materia',
                'anio' => $materia[0],
                'orientacion_id' => 3,
                'curso_id' => DB::table('cursos')->where('ano', $materia[0])->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Materias para Ciclo Básico (ID: 4)
        $materiasCicloBasico = [
            [4, 'Matemática', 'Matemática básica'],
            [5, 'Lengua', 'Lengua y literatura'],
            [6, 'Ciencias Naturales', 'Biología, física y química'],
            [7, 'Ciencias Sociales', 'Historia y geografía'],
        ];

        foreach ($materiasCicloBasico as $materia) {
            DB::table('materias')->insert([
                'nombre' => $materia[1],
                'abreviatura' => substr($materia[1], 0, 3),
                'estado' => 'H',
                'resumen' => $materia[2],
                'tipo' => 'materia',
                'anio' => $materia[0],
                'orientacion_id' => 4,
                'curso_id' => DB::table('cursos')->where('ano', $materia[0])->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
