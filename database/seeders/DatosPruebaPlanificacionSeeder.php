<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Planificacion;

class DatosPruebaPlanificacionSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Iniciando seeder de planificaciones...');

        // Limpiar planificaciones existentes
        DB::table('planificaciones')->delete();

        // Limpiar archivos de prueba anteriores
        if (Storage::disk('local')->exists('planificaciones')) {
            Storage::disk('local')->deleteDirectory('planificaciones');
        }

        // Obtener datos necesarios
        $profesor1 = DB::table('persona')->where('dni', 12345678)->first();
        $profesor2 = DB::table('persona')->where('dni', 23456789)->first();

        if (!$profesor1) {
            $this->command->error('No se encontró el profesor 1. Ejecuta primero: php artisan db:seed --class=DatosPruebaAsistenciaSeeder');
            return;
        }

        // Si no existe el profesor 2, crearlo
        if (!$profesor2) {
            $this->command->info('Creando profesor adicional para pruebas...');

            $localidadId = DB::table('localidades')->first()->id;
            $tipoProfesor = DB::table('tipopersona')->where('tipo', 'Profesor')->first()->id;

            $profesor2Id = DB::table('persona')->insertGetId([
                'dni' => 23456789,
                'apellido' => 'Rodríguez',
                'nombre' => 'Carlos',
                'fechan' => '1985-08-20',
                'sexo' => 'M',
                'domicilio' => 'Av. Rivadavia 5678',
                'id_localidad' => $localidadId,
                'pass' => bcrypt('123456'),
                'telefono' => '11-5678-9012',
                'mail' => 'carlos.rodriguez@escuela.edu.ar'
            ]);

            $tipoUsuarioProfesor2 = DB::table('tipousuario')->insertGetId([
                'id_persona' => $profesor2Id,
                'id_tipopersona' => $tipoProfesor
            ]);

            // Asignar al profesor 2 a algunas materias
            $cupofs = [1001, 1002]; // Matemática y Lengua
            foreach ($cupofs as $cupof) {
                DB::table('revista')->insert([
                    'cupof' => $cupof,
                    'id_tipousuario' => $tipoUsuarioProfesor2,
                    'fd' => '2025-03-01',
                    'fh' => '2025-12-31',
                    'secuencia' => 2,
                    'situacion' => 'A',
                    'estado' => 'A'
                ]);
            }

            $profesor2 = DB::table('persona')->where('dni', 23456789)->first();
        }

        // Obtener los tipos de usuario de ambos profesores
        $tipoUsuarioProfesor1 = DB::table('tipousuario')
            ->where('id_persona', $profesor1->id)
            ->first();

        $tipoUsuarioProfesor2 = DB::table('tipousuario')
            ->where('id_persona', $profesor2->id)
            ->first();

        // Obtener las revistas de ambos profesores
        $revistasProfesor1 = DB::table('revista')
            ->where('id_tipousuario', $tipoUsuarioProfesor1->id)
            ->where('situacion', 'A')
            ->get();

        $revistasProfesor2 = DB::table('revista')
            ->where('id_tipousuario', $tipoUsuarioProfesor2->id)
            ->where('situacion', 'A')
            ->get();

        // Obtener materias
        $materias = DB::table('materias')->get();

        // Crear archivos PDF de prueba y planificaciones
        $planificacionesCreadas = 0;

        // Planificaciones del Profesor 1 (María García)
        foreach ($revistasProfesor1 as $revista) {
            $cupof = DB::table('cupof')->where('cupof', $revista->cupof)->first();
            $materia = $materias->firstWhere('id', $cupof->id_materias);

            // Crear directorio
            $rutaDirectorio = "planificaciones/{$materia->id}/{$revista->id}";
            Storage::disk('local')->makeDirectory($rutaDirectorio);

            // Crear archivo PDF de prueba
            $contenidoPDF = $this->generarContenidoPDF($materia->nombre, $profesor1->nombre . ' ' . $profesor1->apellido);
            $nombreArchivo = "planificacion_anual_{$materia->abreviatura}_" . time() . ".pdf";
            $rutaArchivo = "{$rutaDirectorio}/{$nombreArchivo}";
            Storage::disk('local')->put($rutaArchivo, $contenidoPDF);

            // Crear registro en BD
            Planificacion::create([
                'tamanio' => strlen($contenidoPDF),
                'nombre_archivo' => "Planificación Anual - {$materia->nombre}.pdf",
                'ruta_archivo' => $rutaArchivo,
                'id_materia' => $materia->id,
                'id_revista' => $revista->id,
            ]);

            $planificacionesCreadas++;
            $this->command->info("✓ Planificación creada: {$materia->nombre} - {$profesor1->nombre} {$profesor1->apellido}");
        }

        // Planificaciones del Profesor 2 (Carlos Rodríguez) - Solo para algunas materias
        foreach ($revistasProfesor2 as $revista) {
            $cupof = DB::table('cupof')->where('cupof', $revista->cupof)->first();
            $materia = $materias->firstWhere('id', $cupof->id_materias);

            // Crear directorio
            $rutaDirectorio = "planificaciones/{$materia->id}/{$revista->id}";
            Storage::disk('local')->makeDirectory($rutaDirectorio);

            // Crear archivo PDF de prueba
            $contenidoPDF = $this->generarContenidoPDF($materia->nombre, $profesor2->nombre . ' ' . $profesor2->apellido);
            $nombreArchivo = "planificacion_anual_{$materia->abreviatura}_" . time() . "_p2.pdf";
            $rutaArchivo = "{$rutaDirectorio}/{$nombreArchivo}";
            Storage::disk('local')->put($rutaArchivo, $contenidoPDF);

            // Crear registro en BD
            Planificacion::create([
                'tamanio' => strlen($contenidoPDF),
                'nombre_archivo' => "Planificación Anual - {$materia->nombre}.pdf",
                'ruta_archivo' => $rutaArchivo,
                'id_materia' => $materia->id,
                'id_revista' => $revista->id,
            ]);

            $planificacionesCreadas++;
            $this->command->info("✓ Planificación creada: {$materia->nombre} - {$profesor2->nombre} {$profesor2->apellido}");
        }

        $this->command->info("\n========================================");
        $this->command->info("Datos de prueba de planificaciones creados exitosamente:");
        $this->command->info("========================================");
        $this->command->info("📚 Total de planificaciones: {$planificacionesCreadas}");
        $this->command->info("\n👨‍🏫 Profesores:");
        $this->command->info("   - María García (DNI: 12345678, pass: 123456)");
        $this->command->info("   - Carlos Rodríguez (DNI: 23456789, pass: 123456)");
        $this->command->info("\n📝 Escenarios de prueba:");
        $this->command->info("   - Cada profesor tiene su planificación por materia");
        $this->command->info("   - Pueden ver planificaciones de otros profesores de la misma materia");
        $this->command->info("   - Los archivos están en storage/app/private/planificaciones/");
        $this->command->info("\n🔐 Para probar:");
        $this->command->info("   1. Login como María García (12345678 / 123456)");
        $this->command->info("   2. Ir a Planificaciones");
        $this->command->info("   3. Seleccionar Matemática o Lengua");
        $this->command->info("   4. Verás tu planificación Y la de Carlos Rodríguez");
        $this->command->info("========================================\n");
    }

    /**
     * Genera un contenido PDF básico de prueba
     */
    private function generarContenidoPDF($materia, $profesor)
    {
        return "%PDF-1.4
1 0 obj
<<
/Type /Catalog
/Pages 2 0 R
>>
endobj
2 0 obj
<<
/Type /Pages
/Kids [3 0 R]
/Count 1
>>
endobj
3 0 obj
<<
/Type /Page
/Parent 2 0 R
/Resources <<
/Font <<
/F1 4 0 R
>>
>>
/MediaBox [0 0 612 792]
/Contents 5 0 R
>>
endobj
4 0 obj
<<
/Type /Font
/Subtype /Type1
/BaseFont /Helvetica
>>
endobj
5 0 obj
<<
/Length 200
>>
stream
BT
/F1 24 Tf
50 700 Td
(PLANIFICACION ANUAL) Tj
0 -30 Td
/F1 18 Tf
(Materia: {$materia}) Tj
0 -30 Td
(Profesor: {$profesor}) Tj
0 -30 Td
/F1 12 Tf
(Ciclo Lectivo: 2025) Tj
0 -40 Td
(Este es un archivo de prueba generado automaticamente.) Tj
ET
endstream
endobj
xref
0 6
0000000000 65535 f
0000000009 00000 n
0000000058 00000 n
0000000115 00000 n
0000000274 00000 n
0000000361 00000 n
trailer
<<
/Size 6
/Root 1 0 R
>>
startxref
611
%%EOF";
    }
}
