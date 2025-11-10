<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Personas\Persona;

class DatosPruebaAsistenciaSeeder extends Seeder
{
    public function run(): void
    {
        // Deshabilitar verificación de foreign keys temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // Limpiar tablas relacionadas primero
        DB::table('asignacionesalumnos')->delete();
        DB::table('revista')->delete();
        DB::table('cupof')->delete();
        DB::table('cursociclolectivo')->delete();
        DB::table('grupos')->delete();
        DB::table('cursos')->delete();
        DB::table('materias')->delete();
        DB::table('orientaciones')->delete();
        DB::table('tipousuario')->delete();
        DB::table('tipopersona')->delete();
        DB::table('persona')->delete();
        DB::table('localidades')->delete();

        // Rehabilitar verificación de foreign keys
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        // 1. Crear localidad
        $localidadId = DB::table('localidades')->insertGetId([
            'localidad' => 'Buenos Aires',
            'cp' => 1000,
            'id_provincias' => '1'
        ]);

        // 2. Crear tipos de persona
        $tipoAlumno = DB::table('tipopersona')->insertGetId([
            'tipo' => 'Alumno'
        ]);

        $tipoProfesor = DB::table('tipopersona')->insertGetId([
            'tipo' => 'Profesor'
        ]);
        $tipoJefeDepartamento = DB::table('tipopersona')->insertGetId([
            'tipo' => 'Jefe de Departamento'
        ]);
        


        // 3. Crear personas (1 profesor, 1 jefe de departamento y varios alumnos)
        $profesor = Persona::create([
            'dni' => 12345678,
            'apellido' => 'García',
            'nombre' => 'María',
            'fechan' => '1980-05-15',
            'sexo' => 'F',
            'domicilio' => 'Av. Corrientes 1234',
            'id_localidad' => $localidadId,
            'pass' => '123456',
            'telefono' => '11-1234-5678',
            'mail' => 'maria.garcia@escuela.edu.ar'
        ]);
        $profesorId = $profesor->id;

        // Crear Jefe de Departamento
        $jefeDepartamento = Persona::create([
            'dni' => 20123456,
            'apellido' => 'Morales',
            'nombre' => 'Carlos Alberto',
            'fechan' => '1975-03-20',
            'sexo' => 'M',
            'domicilio' => 'Av. Rivadavia 2345',
            'id_localidad' => $localidadId,
            'pass' => '123456',
            'telefono' => '11-2345-6789',
            'mail' => 'carlos.morales@escuela.edu.ar'
        ]);
        $jefeDepartamentoId = $jefeDepartamento->id;

        // Crear alumnos
        $alumnosData = [
            ['dni' => 45678901, 'apellido' => 'Rodríguez', 'nombre' => 'Juan Carlos'],
            ['dni' => 45678902, 'apellido' => 'Martínez', 'nombre' => 'Ana María'],
            ['dni' => 45678903, 'apellido' => 'López', 'nombre' => 'Pedro José'],
            ['dni' => 45678904, 'apellido' => 'González', 'nombre' => 'María Laura'],
            ['dni' => 45678905, 'apellido' => 'Fernández', 'nombre' => 'Carlos Alberto'],
            ['dni' => 45678906, 'apellido' => 'Sánchez', 'nombre' => 'Lucía Elena'],
            ['dni' => 45678907, 'apellido' => 'Pérez', 'nombre' => 'Diego Martín'],
            ['dni' => 45678908, 'apellido' => 'Torres', 'nombre' => 'Valentina'],
        ];

        $alumnosIds = [];
        foreach ($alumnosData as $alumno) {
            $alumnosIds[] = Persona::create([
                'dni' => $alumno['dni'],
                'apellido' => $alumno['apellido'],
                'nombre' => $alumno['nombre'],
                'fechan' => '2005-01-01',
                'sexo' => 'M',
                'domicilio' => 'Calle Falsa 123',
                'id_localidad' => $localidadId,
                'pass' => '123456',
                'telefono' => '11-0000-0000',
                'mail' => Str::lower($alumno['nombre'] . '.' . $alumno['apellido']) . '@estudiante.edu.ar'
            ])->id;
        }

        // 4. Crear tipos de usuario
        $tipoUsuarioProfesor = DB::table('tipousuario')->insertGetId([
            'id_persona' => $profesorId,
            'id_tipopersona' => $tipoProfesor
        ]);

        $tipoUsuarioJefeDepartamento = DB::table('tipousuario')->insertGetId([
            'id_persona' => $jefeDepartamentoId,
            'id_tipopersona' => $tipoJefeDepartamento
        ]);

        $tiposUsuarioAlumnos = [];
        foreach ($alumnosIds as $alumnoId) {
            $tiposUsuarioAlumnos[] = DB::table('tipousuario')->insertGetId([
                'id_persona' => $alumnoId,
                'id_tipopersona' => $tipoAlumno
            ]);
        }

        // 5. Crear orientación
        $orientacionId = DB::table('orientaciones')->insertGetId([
            'nombre' => 'Ciencias Naturales',
            'titulo' => 'Bachiller en Ciencias Naturales',
            'color' => '#4CAF50'
        ]);

        // 6. Crear materias
        $materiasData = [
            ['nombre' => 'Matemática', 'abreviatura' => 'MAT', 'estado' => 'H', 'resumen' => 'Matemática básica'],
            ['nombre' => 'Lengua y Literatura', 'abreviatura' => 'LYL', 'estado' => 'H', 'resumen' => 'Lengua y Literatura'],
            ['nombre' => 'Historia', 'abreviatura' => 'HIST', 'estado' => 'H', 'resumen' => 'Historia Argentina'],
            ['nombre' => 'Biología', 'abreviatura' => 'BIO', 'estado' => 'H', 'resumen' => 'Biología General'],
        ];

        $materiasIds = [];
        foreach ($materiasData as $materia) {
            $materiasIds[] = DB::table('materias')->insertGetId($materia);
        }

        // 7. Crear curso
        $cursoId = DB::table('cursos')->insertGetId([
            'division' => 'A',
            'ano' => 4,
            'turno' => 'M',
            'estado' => 'A'
        ]);

        // 8. Crear grupo
        $grupoId = DB::table('grupos')->insertGetId([
            'nombre' => 1,
            'id_cursos' => $cursoId
        ]);

        // 9. Crear ciclo lectivo
        $cicloLectivoId = DB::table('cursociclolectivo')->insertGetId([
            'id_cursos' => $cursoId,
            'ciclolectivo' => 2025,
            'estado' => 'A'
        ]);

        // 10. Crear CUPOFs
        $cupofs = [];
        foreach ($materiasIds as $index => $materiaId) {
            $cupofNumero = 1000 + $index + 1;
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

        // 11. Crear revistas (asignar profesor a los CUPOFs)
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

        // 12. Crear asignaciones de alumnos
        foreach ($tiposUsuarioAlumnos as $tipoUsuarioAlumno) {
            DB::table('asignacionesalumnos')->insert([
                'id_cursosciclolectivo' => $cicloLectivoId,
                'id_tipousuario' => $tipoUsuarioAlumno,
                'id_grupos' => $grupoId,
                'estado' => 'A'
            ]);
        }

        $this->command->info('Datos de prueba creados exitosamente:');
        $this->command->info('- Profesor: María García (DNI: 12345678, pass: 123456)');
        $this->command->info('- Jefe de Departamento: Carlos Alberto Morales (DNI: 20123456, pass: 123456)');
        $this->command->info('- 8 alumnos en 4° A turno mañana');
        $this->command->info('- 4 materias con CUPOFs asignados');
        $this->command->info('- Ciclo lectivo 2025 activo');
    }
}
