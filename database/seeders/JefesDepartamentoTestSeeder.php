<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Personas\Persona;
use App\Models\Personas\TipoPersona;
use App\Models\Personas\TipoUsuario;
use App\Models\Materia;

class JefesDepartamentoTestSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creando datos de prueba para Jefes de Departamento...');

        // 1. Obtener o crear tipo de persona "Profesor"
        $tipoProfesor = TipoPersona::firstOrCreate(
            ['tipo' => 'Profesor'],
        );

        // 2. Crear departamentos
        $departamentosData = [
            ['nombre' => 'Matemática y Física', 'descripcion' => 'Departamento de Ciencias Exactas'],
            ['nombre' => 'Lengua y Literatura', 'descripcion' => 'Departamento de Humanidades'],
            ['nombre' => 'Ciencias Sociales', 'descripcion' => 'Departamento de Historia y Geografía'],
            ['nombre' => 'Ciencias Naturales', 'descripcion' => 'Departamento de Biología y Química'],
        ];

        // 3. Crear jefes de departamento (profesores)
        $jefesData = [
            [
                'dni' => 30111222,
                'apellido' => 'Gómez',
                'nombre' => 'Roberto Carlos',
                'email' => 'roberto.gomez@escuela.edu.ar',
                'departamento' => 'Matemática y Física',
            ],
            [
                'dni' => 30222333,
                'apellido' => 'Silva',
                'nombre' => 'Patricia Andrea',
                'email' => 'patricia.silva@escuela.edu.ar',
                'departamento' => 'Lengua y Literatura',
            ],
            [
                'dni' => 30333444,
                'apellido' => 'Ramírez',
                'nombre' => 'Jorge Luis',
                'email' => 'jorge.ramirez@escuela.edu.ar',
                'departamento' => 'Ciencias Sociales',
            ],
            [
                'dni' => 30444555,
                'apellido' => 'Méndez',
                'nombre' => 'Laura Beatriz',
                'email' => 'laura.mendez@escuela.edu.ar',
                'departamento' => 'Ciencias Naturales',
            ],
        ];

        $jefes = [];
        $localidadId = DB::table('localidades')->first()->id ?? 1;

        foreach ($jefesData as $jefeData) {
            // Crear persona
            $persona = Persona::firstOrCreate(
                ['dni' => $jefeData['dni']],
                [
                    'apellido' => $jefeData['apellido'],
                    'nombre' => $jefeData['nombre'],
                    'fechan' => '1975-01-01',
                    'sexo' => in_array($jefeData['nombre'], ['Patricia Andrea', 'Laura Beatriz']) ? 'F' : 'M',
                    'domicilio' => 'Calle Ejemplo 123',
                    'id_localidad' => $localidadId,
                    'pass' => '123456',
                    'telefono' => '11-' . rand(1000, 9999) . '-' . rand(1000, 9999),
                    'mail' => $jefeData['email']
                ]
            );

            // Crear TipoUsuario
            $tipoUsuario = TipoUsuario::firstOrCreate(
                [
                    'id_persona' => $persona->id,
                    'id_tipopersona' => $tipoProfesor->id
                ],
                [
                    'estado' => 'A'
                ]
            );

            // Crear Departamento
            $departamento = \App\Models\Departamento::firstOrCreate(
                ['nombre' => $departamentosData[count($jefes)]['nombre']],
                [
                    'id_tipousuario' => $tipoUsuario->id,
                    'descripcion' => $departamentosData[array_search($jefeData['departamento'], array_column($departamentosData, 'nombre'))]['descripcion'],
                    'estado' => 'A'
                ]
            );

            $jefes[] = [
                'tipoUsuario' => $tipoUsuario,
                'departamento' => $departamento,
                'persona' => $persona
            ];

            $this->command->info("✓ Jefe creado: {$persona->nombre_completo} (DNI: {$persona->dni})");
        }

        // 3. Obtener materias existentes o crear algunas de ejemplo
        $materias = Materia::all();

        if ($materias->isEmpty()) {
            $this->command->warn('No hay materias. Creando materias de ejemplo...');

            $orientacionId = DB::table('orientaciones')->first()->id ?? null;

            $materiasEjemplo = [
                ['nombre' => 'Matemática', 'abreviatura' => 'MAT', 'resumen' => 'Matemática General'],
                ['nombre' => 'Física', 'abreviatura' => 'FIS', 'resumen' => 'Física General'],
                ['nombre' => 'Lengua', 'abreviatura' => 'LEN', 'resumen' => 'Lengua y Literatura'],
                ['nombre' => 'Literatura', 'abreviatura' => 'LIT', 'resumen' => 'Literatura Universal'],
                ['nombre' => 'Historia', 'abreviatura' => 'HIST', 'resumen' => 'Historia Argentina'],
                ['nombre' => 'Geografía', 'abreviatura' => 'GEO', 'resumen' => 'Geografía Mundial'],
                ['nombre' => 'Biología', 'abreviatura' => 'BIO', 'resumen' => 'Biología General'],
                ['nombre' => 'Química', 'abreviatura' => 'QUI', 'resumen' => 'Química General'],
            ];

            foreach ($materiasEjemplo as $mat) {
                Materia::create(array_merge($mat, [
                    'estado' => 'H',
                    'orientacion_id' => $orientacionId,
                    'anio' => null,
                    'tipo' => null
                ]));
            }

            $materias = Materia::all();
        }

        // 4. Asignar materias a jefes de departamento
        $asignaciones = [
            // Roberto Gómez - Matemática y Física
            ['jefe_index' => 0, 'materias' => ['Matemática', 'Física']],
            // Patricia Silva - Lengua y Literatura
            ['jefe_index' => 1, 'materias' => ['Lengua', 'Literatura', 'Lengua y Literatura']],
            // Jorge Ramírez - Ciencias Sociales
            ['jefe_index' => 2, 'materias' => ['Historia', 'Geografía']],
            // Laura Méndez - Ciencias Naturales
            ['jefe_index' => 3, 'materias' => ['Biología', 'Química']],
        ];

        $totalAsignaciones = 0;
        foreach ($asignaciones as $asignacion) {
            $jefe = $jefes[$asignacion['jefe_index']];

            foreach ($asignacion['materias'] as $nombreMateria) {
                $materia = $materias->firstWhere('nombre', $nombreMateria);

                if ($materia) {
                    // Usar la tabla pivote departamento_materia
                    $jefe['departamento']->materias()->attach($materia->id);

                    $totalAsignaciones++;
                    $this->command->info("  → Materia asignada: {$materia->nombre}");
                }
            }
        }

        $this->command->newLine();
        $this->command->info('=== Resumen ===');
        $this->command->info("Jefes de Departamento creados: " . count($jefes));
        $this->command->info("Asignaciones activas: {$totalAsignaciones}");
        $this->command->info("Materias disponibles: {$materias->count()}");
        $this->command->newLine();

        $this->command->info('Credenciales de acceso (todos con password: 123456):');
        foreach ($jefes as $jefe) {
            $this->command->info("  - DNI: {$jefe['persona']->dni} | {$jefe['persona']->nombre_completo} ({$jefe['departamento']->nombre})");
        }
    }
}
