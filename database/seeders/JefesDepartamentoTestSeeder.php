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
            $departamento = \App\Models\Departamento::updateOrCreate(
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
        $this->command->newLine();
        $this->command->info('Asignando materias a departamentos...');

        // Obtener materias que ya tienen profesores asignados
        $materiasConProfesores = DB::table('revista')
            ->join('cupof', 'revista.cupof', '=', 'cupof.cupof')
            ->join('materias', 'cupof.id_materias', '=', 'materias.id')
            ->where('revista.situacion', 'A')
            ->where('cupof.estado', 'A')
            ->select('materias.nombre')
            ->distinct()
            ->pluck('nombre')
            ->toArray();

        $this->command->info('Materias con profesores asignados: ' . implode(', ', $materiasConProfesores));

        $asignaciones = [
            // Roberto Gómez - Matemática y Física (usar materias existentes)
            ['jefe_index' => 0, 'materias' => array_intersect(['Matemática', 'Física'], $materiasConProfesores)],
            // Patricia Silva - Lengua y Literatura
            ['jefe_index' => 1, 'materias' => array_intersect(['Lengua', 'Literatura', 'Lengua y Literatura'], $materiasConProfesores)],
            // Jorge Ramírez - Ciencias Sociales
            ['jefe_index' => 2, 'materias' => array_intersect(['Historia', 'Geografía'], $materiasConProfesores)],
            // Laura Méndez - Ciencias Naturales
            ['jefe_index' => 3, 'materias' => array_intersect(['Biología', 'Química'], $materiasConProfesores)],
        ];
        $totalAsignaciones = 0;
        foreach ($asignaciones as $asignacion) {
            $jefe = $jefes[$asignacion['jefe_index']];

            if (empty($asignacion['materias'])) {
                $this->command->warn("  ⚠ No hay materias con profesores para {$jefe['persona']->nombre_completo}");
                continue;
            }

            foreach ($asignacion['materias'] as $nombreMateria) {
                $materia = $materias->firstWhere('nombre', $nombreMateria);

                if ($materia) {
                    // Verificar que la materia tenga profesores asignados
                    $tieneProfesores = DB::table('revista')
                        ->join('cupof', 'revista.cupof', '=', 'cupof.cupof')
                        ->where('cupof.id_materias', $materia->id)
                        ->where('revista.situacion', 'A')
                        ->where('cupof.estado', 'A')
                        ->exists();

                    if ($tieneProfesores) {
                        // Usar la tabla pivote departamento_materia
                        $jefe['departamento']->materias()->syncWithoutDetaching([$materia->id]);

                        $totalAsignaciones++;

                        // Contar profesores de esta materia
                        $cantidadProfesores = DB::table('revista')
                            ->join('cupof', 'revista.cupof', '=', 'cupof.cupof')
                            ->where('cupof.id_materias', $materia->id)
                            ->where('revista.situacion', 'A')
                            ->where('cupof.estado', 'A')
                            ->distinct('revista.id_tipousuario')
                            ->count('revista.id_tipousuario');

                        $this->command->info("  ✓ Materia asignada: {$materia->nombre} ({$cantidadProfesores} profesor/es)");
                    }
                }
            }
        }

        if ($totalAsignaciones === 0) {
            $this->command->warn('No se pudieron asignar materias. Asegúrate de ejecutar primero DatosPruebaAsistenciaSeeder.');
        }

        // 5. Crear profesores adicionales para el departamento de Matemática y Física
        $this->command->newLine();
        $this->command->info('Creando profesores adicionales para Matemática y Física...');

        $departamentoMatematica = $jefes[0]['departamento'];
        $materiasMatematica = $jefes[0]['departamento']->materias()->get();

        // Asignar materias a Roberto Gómez como profesor
        $this->command->info('Asignando materias a Roberto Gómez como profesor...');
        
        $tipoUsuarioRoberto = $jefes[0]['tipoUsuario'];
        $cursos = DB::table('cursos')->where('estado', 'A')->get();
        $ultimoCupof = DB::table('cupof')->max('cupof') ?? 2000;
        
        if (!$cursos->isEmpty() && !$materiasMatematica->isEmpty()) {
            $materiasRoberto = $materiasMatematica->take(2); // Asignar primeras 2 materias
            $cupofCount = 0;
            
            foreach ($materiasRoberto as $materia) {
                foreach ($cursos->take(2) as $curso) { // Asignar a 2 cursos
                    $grupo = DB::table('grupos')->where('id_cursos', $curso->id)->first();
                    if (!$grupo) {
                        $grupoId = DB::table('grupos')->insertGetId([
                            'nombre' => 1,
                            'id_cursos' => $curso->id
                        ]);
                    } else {
                        $grupoId = $grupo->id;
                    }
                    
                    $cupofNumero = $ultimoCupof + 100 + $cupofCount;
                    
                    DB::table('cupof')->insert([
                        'cupof' => $cupofNumero,
                        'turno' => 'M',
                        'hsmodcar' => 4,
                        'id_materias' => $materia->id,
                        'id_cursos' => $curso->id,
                        'id_grupos' => $grupoId,
                        'estado' => 'A',
                        'funcion' => 'PROF',
                        'cargo' => 'TIT'
                    ]);
                    
                    DB::table('revista')->insert([
                        'cupof' => $cupofNumero,
                        'id_tipousuario' => $tipoUsuarioRoberto->id,
                        'fd' => now()->startOfYear()->format('Y-m-d'),
                        'fh' => now()->endOfYear()->format('Y-m-d'),
                        'secuencia' => 1,
                        'situacion' => 'A',
                        'estado' => 'A'
                    ]);
                    
                    $cupofCount++;
                    $this->command->info("  ✓ Roberto Gómez asignado a {$materia->nombre} ({$curso->ano}º {$curso->division})");
                }
            }
        } else {
            $this->command->warn('No hay cursos activos o materias disponibles para Roberto Gómez.');
        }

        // Crear o buscar curso 7º C
        $this->command->newLine();
        $this->command->info('Creando/buscando curso 7º C...');
        
        $cursoSeptimoC = DB::table('cursos')
            ->where('ano', 7)
            ->where('division', 'C')
            ->first();
        
        if (!$cursoSeptimoC) {
            // Crear nuevo curso 7º C
            $cursoSeptimoC = DB::table('cursos')->insertGetId([
                'ano' => 7,
                'division' => 'C',
                'turno' => 'M',
                'estado' => 'A',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            // Obtener el registro completo
            $cursoSeptimoC = DB::table('cursos')->where('id', $cursoSeptimoC)->first();
            $this->command->info("  ✓ Curso 7º C creado exitosamente");
        } else {
            $this->command->info("  ✓ Curso 7º C ya existe");
        }
        
        // Asignar materia nueva a Roberto Gómez en 7º C
        $this->command->info('Asignando materia nueva a Roberto Gómez en 7º C...');
        
        if ($cursoSeptimoC && !$materiasMatematica->isEmpty()) {
            // Obtener o crear grupo de 7º C
            $grupoSeptimoC = DB::table('grupos')
                ->where('id_cursos', $cursoSeptimoC->id)
                ->first();
            
            if (!$grupoSeptimoC) {
                $grupoId = DB::table('grupos')->insertGetId([
                    'nombre' => 1,
                    'id_cursos' => $cursoSeptimoC->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                $grupoId = $grupoSeptimoC->id;
            }
            
            // Usar la última materia disponible
            $materiaNueva = $materiasMatematica->last();
            $cupofNuevo = $ultimoCupof + 200;
            
            DB::table('cupof')->insert([
                'cupof' => $cupofNuevo,
                'turno' => 'M',
                'hsmodcar' => 4,
                'id_materias' => $materiaNueva->id,
                'id_cursos' => $cursoSeptimoC->id,
                'id_grupos' => $grupoId,
                'estado' => 'A',
                'funcion' => 'PROF',
                'cargo' => 'TIT'
            ]);
            
            DB::table('revista')->insert([
                'cupof' => $cupofNuevo,
                'id_tipousuario' => $tipoUsuarioRoberto->id,
                'fd' => now()->startOfYear()->format('Y-m-d'),
                'fh' => now()->endOfYear()->format('Y-m-d'),
                'secuencia' => 1,
                'situacion' => 'A',
                'estado' => 'A'
            ]);
            
            $this->command->info("  ✓ Roberto Gómez asignado a {$materiaNueva->nombre} en 7º C (CUPOF: {$cupofNuevo})");
        } else {
            $this->command->warn('No hay materias disponibles para asignar.');
        }

        // Obtener cursos existentes
        $cursos = DB::table('cursos')->where('estado', 'A')->get();

        if ($cursos->isEmpty() || $materiasMatematica->isEmpty()) {
            $this->command->warn('No hay cursos activos o materias asignadas. No se pueden crear profesores adicionales.');
        } else {
            $profesoresData = [
                ['dni' => 31111111, 'apellido' => 'González', 'nombre' => 'María Laura', 'sexo' => 'F'],
                ['dni' => 31222222, 'apellido' => 'Rodríguez', 'nombre' => 'Carlos Alberto', 'sexo' => 'M'],
                ['dni' => 31333333, 'apellido' => 'Fernández', 'nombre' => 'Ana Beatriz', 'sexo' => 'F'],
                ['dni' => 31444444, 'apellido' => 'López', 'nombre' => 'Juan Pablo', 'sexo' => 'M'],
                ['dni' => 31555555, 'apellido' => 'Martínez', 'nombre' => 'Silvia Roxana', 'sexo' => 'F'],
                ['dni' => 31666666, 'apellido' => 'Pérez', 'nombre' => 'Roberto Daniel', 'sexo' => 'M'],
                ['dni' => 31777777, 'apellido' => 'García', 'nombre' => 'Claudia Mónica', 'sexo' => 'F'],
                ['dni' => 31888888, 'apellido' => 'Sánchez', 'nombre' => 'Marcelo Fabián', 'sexo' => 'M'],
                ['dni' => 31999999, 'apellido' => 'Romero', 'nombre' => 'Gabriela Andrea', 'sexo' => 'F'],
                ['dni' => 32111111, 'apellido' => 'Torres', 'nombre' => 'Diego Martín', 'sexo' => 'M'],
                ['dni' => 32222222, 'apellido' => 'Flores', 'nombre' => 'Verónica Soledad', 'sexo' => 'F'],
                ['dni' => 32333333, 'apellido' => 'Benítez', 'nombre' => 'Sergio Alejandro', 'sexo' => 'M'],
                ['dni' => 32444444, 'apellido' => 'Ruiz', 'nombre' => 'Natalia Vanesa', 'sexo' => 'F'],
                ['dni' => 32555555, 'apellido' => 'Morales', 'nombre' => 'Fernando Nicolás', 'sexo' => 'M'],
                ['dni' => 32666666, 'apellido' => 'Castro', 'nombre' => 'Mariana Florencia', 'sexo' => 'F'],
                ['dni' => 32777777, 'apellido' => 'Vargas', 'nombre' => 'Gustavo Adrián', 'sexo' => 'M'],
                ['dni' => 32888888, 'apellido' => 'Álvarez', 'nombre' => 'Carolina Viviana', 'sexo' => 'F'],
                ['dni' => 32999999, 'apellido' => 'Giménez', 'nombre' => 'Pablo César', 'sexo' => 'M'],
                ['dni' => 33111111, 'apellido' => 'Acosta', 'nombre' => 'Cecilia Raquel', 'sexo' => 'F'],
                ['dni' => 33222222, 'apellido' => 'Medina', 'nombre' => 'Martín Ezequiel', 'sexo' => 'M'],
            ];

            $profesoresCreados = 0;
            $ultimoCupof = DB::table('cupof')->max('cupof') ?? 2000;
            $cicloLectivoId = DB::table('cursociclolectivo')->where('estado', 'A')->value('ciclolectivo') ?? 2025;

            foreach ($profesoresData as $index => $profData) {
                // Crear persona
                $persona = Persona::firstOrCreate(
                    ['dni' => $profData['dni']],
                    [
                        'apellido' => $profData['apellido'],
                        'nombre' => $profData['nombre'],
                        'fechan' => '1980-01-01',
                        'sexo' => $profData['sexo'],
                        'domicilio' => 'Calle Ejemplo ' . rand(100, 999),
                        'id_localidad' => $localidadId,
                        'pass' => '123456',
                        'telefono' => '11-' . rand(1000, 9999) . '-' . rand(1000, 9999),
                        'mail' => strtolower($profData['nombre']) . '.' . strtolower($profData['apellido']) . '@escuela.edu.ar'
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

                // Asignar materia (alternando entre Matemática y Física)
                $materia = $materiasMatematica[$index % $materiasMatematica->count()];

                // Seleccionar un curso al azar
                $curso = $cursos->random();

                // Obtener o crear grupo para el curso
                $grupo = DB::table('grupos')->where('id_cursos', $curso->id)->first();
                if (!$grupo) {
                    $grupoId = DB::table('grupos')->insertGetId([
                        'nombre' => 1,
                        'id_cursos' => $curso->id
                    ]);
                } else {
                    $grupoId = $grupo->id;
                }

                // Crear CUPOF (sin id, sin created_at/updated_at)
                $cupofNumero = $ultimoCupof + $profesoresCreados + 1;

                DB::table('cupof')->insert([
                    'cupof' => $cupofNumero,
                    'turno' => 'M',
                    'hsmodcar' => 4,
                    'id_materias' => $materia->id,
                    'id_cursos' => $curso->id,
                    'id_grupos' => $grupoId,
                    'estado' => 'A',
                    'funcion' => 'PROF',
                    'cargo' => 'TIT'
                ]);

                // Crear Revista
                DB::table('revista')->insert([
                    'cupof' => $cupofNumero,
                    'id_tipousuario' => $tipoUsuario->id,
                    'fd' => now()->startOfYear()->format('Y-m-d'),
                    'fh' => now()->endOfYear()->format('Y-m-d'),
                    'secuencia' => 1,
                    'situacion' => 'A',
                    'estado' => 'A'
                ]);

                $profesoresCreados++;
                $this->command->info("✓ Profesor creado: {$persona->nombre_completo} - {$materia->nombre} ({$curso->ano}º {$curso->division})");
            }

            $this->command->info("Total de profesores adicionales creados: {$profesoresCreados}");
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
