<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Personas\Persona;

class DatosPruebaAsistenciaSeeder2 extends Seeder
{
    public function run(): void
    {
        // NO limpiamos las tablas para agregar datos adicionales
        
        // 1. Obtener la localidad existente
        $localidadId = DB::table('localidades')->where('localidad', 'Buenos Aires')->value('id');

        // 2. Obtener tipos de persona existentes
        $tipoAlumno = DB::table('tipopersona')->where('tipo', 'Alumno')->value('id');
        $tipoProfesor = DB::table('tipopersona')->where('tipo', 'Profesor')->value('id');

        // 3. Crear nuevo profesor
        $profesor = Persona::create([
            'dni' => 23456789,
            'apellido' => 'Ramírez',
            'nombre' => 'Roberto',
            'fechan' => '1978-08-22',
            'sexo' => 'M',
            'domicilio' => 'Av. San Martín 5678',
            'id_localidad' => $localidadId,
            'pass' => '123456',
            'telefono' => '11-234-5678',
            'mail' => 'roberto.ramirez@escuela.edu.ar'
        ]);
        $profesorId = $profesor->id;

        // Crear nuevos alumnos
        $alumnosData = [
            ['dni' => 46789012, 'apellido' => 'Acosta', 'nombre' => 'Sofía Belén'],
            ['dni' => 46789013, 'apellido' => 'Benítez', 'nombre' => 'Mateo Ezequiel'],
            ['dni' => 46789014, 'apellido' => 'Castro', 'nombre' => 'Valentina Sol'],
            ['dni' => 46789015, 'apellido' => 'Díaz', 'nombre' => 'Facundo Agustín'],
            ['dni' => 46789016, 'apellido' => 'Espinoza', 'nombre' => 'Martina Abril'],
            ['dni' => 46789017, 'apellido' => 'Flores', 'nombre' => 'Tomás Benjamín'],
            ['dni' => 46789018, 'apellido' => 'Giménez', 'nombre' => 'Camila Rocío'],
            ['dni' => 46789019, 'apellido' => 'Herrera', 'nombre' => 'Nicolás Dante'],
        ];

        $alumnosIds = [];
        foreach ($alumnosData as $alumno) {
            $alumnosIds[] = Persona::create([
                'dni' => $alumno['dni'],
                'apellido' => $alumno['apellido'],
                'nombre' => $alumno['nombre'],
                'fechan' => '2006-06-15',
                'sexo' => 'M',
                'domicilio' => 'Av. Libertador 456',
                'id_localidad' => $localidadId,
                'pass' => '123456',
                'telefono' => '11-000-0000',
                'mail' => Str::lower($alumno['nombre'] . '.' . $alumno['apellido']) . '@estudiante.edu.ar'
            ])->id;
        }

        // 4. Crear tipos de usuario
        $tipoUsuarioProfesor = DB::table('tipousuario')->insertGetId([
            'id_persona' => $profesorId,
            'id_tipopersona' => $tipoProfesor
        ]);

        $tiposUsuarioAlumnos = [];
        foreach ($alumnosIds as $alumnoId) {
            $tiposUsuarioAlumnos[] = DB::table('tipousuario')->insertGetId([
                'id_persona' => $alumnoId,
                'id_tipopersona' => $tipoAlumno
            ]);
        }

        // 5. Obtener las materias existentes
        $materiasIds = DB::table('materias')->pluck('id')->toArray();

        // 6. Obtener el curso existente (4° A)
        $cursoId = DB::table('cursos')
            ->where('division', 'A')
            ->where('ano', 4)
            ->where('turno', 'M')
            ->value('id');

        // 7. Obtener el grupo existente
        $grupoId = DB::table('grupos')
            ->where('id_cursos', $cursoId)
            ->where('nombre', 1)
            ->value('id');

        // 8. Obtener el ciclo lectivo existente
        $cicloLectivoId = DB::table('cursociclolectivo')
            ->where('id_cursos', $cursoId)
            ->where('ciclolectivo', 2025)
            ->value('id');

        // 9. Crear nuevos CUPOFs (con números diferentes)
        $cupofs = [];
        foreach ($materiasIds as $index => $materiaId) {
            $cupofNumero = 2000 + $index + 1;
            $cupofs[] = $cupofNumero;

            DB::table('cupof')->insert([
                'cupof' => $cupofNumero,
                'turno' => 'M',
                'hsmodcar' => 4,
                'id_materias' => $materiaId,
                'id_cursos' => $cursoId,
                'id_grupos' => $grupoId,
                'estado' => 'A',
                'funcion' => 'PROF',
                'cargo' => 'TIT'
            ]);
        }

        // 10. Crear revistas (asignar nuevo profesor a los nuevos CUPOFs)
        foreach ($cupofs as $cupof) {
            DB::table('revista')->insert([
                'cupof' => $cupof,
                'id_tipousuario' => $tipoUsuarioProfesor,
                'fd' => '2025-03-01',
                'fh' => '2025-12-31',
                'secuencia' => 1,
                'situacion' => 'A',
                'estado' => 'A'
            ]);
        }

        // 11. Crear asignaciones de nuevos alumnos al mismo curso
        foreach ($tiposUsuarioAlumnos as $tipoUsuarioAlumno) {
            DB::table('asignacionesalumnos')->insert([
                'id_cursosciclolectivo' => $cicloLectivoId,
                'id_tipousuario' => $tipoUsuarioAlumno,
                'id_grupos' => $grupoId,
                'estado' => 'A'
            ]);
        }

        $this->command->info('Datos de prueba 2 creados exitosamente:');
        $this->command->info('- Profesor: Roberto Ramírez (DNI: 23456789, pass: 123456)');
        $this->command->info('- 8 nuevos alumnos agregados al mismo 4° A turno mañana');
        $this->command->info('- Nuevos CUPOFs (2001-2004) asignados para las mismas materias');
        $this->command->info('- Se mantiene el mismo curso y ciclo lectivo 2025');
    }
}