<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Proyecto;
use App\Models\Revista;
use App\Models\Cupof;
use Carbon\Carbon;

class ProyectosTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Iniciando seeder de proyectos de prueba...');

        // Verificar que existan revistas activas
        $revistas = Revista::where('situacion', 'A')
            ->where('estado', 'A')
            ->with(['tipoUsuario.persona'])
            ->get();

        if ($revistas->isEmpty()) {
            $this->command->error('❌ No hay revistas activas. Ejecuta primero DatosPruebaAsistenciaSeeder');
            return;
        }

        $this->command->info("✅ Encontradas {$revistas->count()} revistas activas");

        // Crear directorio de proyectos si no existe
        if (!Storage::disk('local')->exists('proyectos')) {
            Storage::disk('local')->makeDirectory('proyectos');
        }

        $proyectosCreados = 0;
        $archivosCreados = 0;

        // Datos de proyectos de ejemplo (solo nombre y extensión)
        $proyectosData = [
            ['nombre' => 'Sistema_Gestion_Escolar', 'extension' => 'pdf'],
            ['nombre' => 'Analisis_Estadistico_Resultados', 'extension' => 'xlsx'],
            ['nombre' => 'Planificacion_Anual_Detallada', 'extension' => 'docx'],
            ['nombre' => 'Presentacion_Multimedia', 'extension' => 'pptx'],
            ['nombre' => 'Recursos_Material_Complementario', 'extension' => 'zip'],
            ['nombre' => 'Guia_Ejercicios_Practicos', 'extension' => 'pdf'],
            ['nombre' => 'Base_Datos_Alumnos', 'extension' => 'xlsx'],
            ['nombre' => 'Informe_Trimestral', 'extension' => 'docx'],
        ];

        // Crear proyectos para cada revista
        foreach ($revistas as $revista) {
            $cupofNumero = $revista->cupof;

            // Obtener información del CUPOF
            $cupofInfo = Cupof::where('cupof', $cupofNumero)
                ->with(['materia', 'curso', 'grupo'])
                ->first();

            if (!$cupofInfo) {
                $this->command->warn("⚠️  CUPOF {$cupofNumero} no encontrado, saltando...");
                continue;
            }

            $materiaInfo = $cupofInfo->materia->nombre ?? 'Materia desconocida';
            $cursoInfo = ($cupofInfo->curso->ano ?? '') . '° ' . ($cupofInfo->curso->division ?? '');
            $grupoInfo = $cupofInfo->grupo->nombre ?? '';

            $profesorNombre = $revista->tipoUsuario->persona->nombre ?? '';
            $profesorApellido = $revista->tipoUsuario->persona->apellido ?? '';
            $profesorInfo = trim("{$profesorApellido}, {$profesorNombre}");

            $this->command->info("📚 Procesando: {$materiaInfo} - {$cursoInfo} {$grupoInfo} - Prof: {$profesorInfo}");

            // Crear directorio específico para este cupof/revista
            $rutaDirectorio = "proyectos/{$cupofNumero}/{$revista->id}";
            if (!Storage::disk('local')->exists($rutaDirectorio)) {
                Storage::disk('local')->makeDirectory($rutaDirectorio);
            }

            // Crear 2-4 proyectos aleatorios por revista
            $cantidadProyectos = rand(2, 4);
            $proyectosSeleccionados = collect($proyectosData)
                ->shuffle()
                ->take($cantidadProyectos);

            foreach ($proyectosSeleccionados as $proyectoData) {
                try {
                    // Crear nombre de archivo único
                    $timestamp = time() + $proyectosCreados + rand(1, 999);
                    $nombreArchivo = "{$proyectoData['nombre']}_{$timestamp}.{$proyectoData['extension']}";
                    $rutaArchivo = "{$rutaDirectorio}/{$nombreArchivo}";

                    // Crear archivo de prueba (contenido simulado)
                    $contenido = $this->generarContenidoArchivo($proyectoData['extension'], $proyectoData['nombre']);
                    Storage::disk('local')->put($rutaArchivo, $contenido);
                    $archivosCreados++;

                    $tamanioBytes = strlen($contenido);

                    // Crear registro en la base de datos - SOLO campos de la migración
                    $proyecto = Proyecto::create([
                        'tamanio' => $tamanioBytes,
                        'nombre_archivo' => $nombreArchivo,
                        'ruta_archivo' => $rutaArchivo,
                        'id_revista' => $revista->id,
                        'cupof' => $cupofNumero,
                        'created_at' => Carbon::now()->subDays(rand(1, 30)),
                        'updated_at' => Carbon::now()->subDays(rand(0, 15)),
                    ]);

                    $proyectosCreados++;

                    // Formatear tamaño
                    $tamanioFormateado = $this->formatearTamanio($tamanioBytes);

                    $this->command->info("   ✓ {$nombreArchivo} - {$tamanioFormateado}");
                } catch (\Exception $e) {
                    $this->command->error("   ✗ Error: {$e->getMessage()}");
                }
            }

            $this->command->newLine();
        }

        // Resumen final
        $this->command->info('═══════════════════════════════════════════════════════════');
        $this->command->info("✅ Seeder completado exitosamente");
        $this->command->info("📊 Resumen:");
        $this->command->info("   • Proyectos en BD: {$proyectosCreados}");
        $this->command->info("   • Archivos físicos: {$archivosCreados}");
        $this->command->info("   • Revistas procesadas: {$revistas->count()}");
        $this->command->info("   • Ubicación: storage/app/private/proyectos/");
        $this->command->info('═══════════════════════════════════════════════════════════');
        $this->command->newLine();
        $this->command->info('💡 Credenciales de prueba:');
        $this->command->info('   Usuario: 12345678 (Profesor)');
        $this->command->info('   Contraseña: 123456');
        $this->command->info('   Ruta: /profesores/proyectos');
    }

    /**
     * Formatear tamaño de bytes a formato legible
     */
    private function formatearTamanio(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' bytes';
    }

    /**
     * Generar contenido simulado para archivos según su extensión
     */
    private function generarContenidoArchivo(string $extension, string $nombre): string
    {
        switch ($extension) {
            case 'pdf':
                return $this->generarPDFSimulado($nombre);
            case 'docx':
                return $this->generarDOCXSimulado($nombre);
            case 'xlsx':
                return $this->generarXLSXSimulado($nombre);
            case 'pptx':
                return $this->generarPPTXSimulado($nombre);
            case 'zip':
                return $this->generarZIPSimulado($nombre);
            default:
                return "Contenido de prueba para: {$nombre}\n" . str_repeat("Datos de ejemplo.\n", 1000);
        }
    }

    /**
     * Generar contenido simulado para PDF
     */
    private function generarPDFSimulado(string $nombre): string
    {
        $contenido = "%PDF-1.4
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
/MediaBox [0 0 612 792]
/Contents 4 0 R
/Resources <<
/Font <<
/F1 <<
/Type /Font
/Subtype /Type1
/BaseFont /Helvetica
>>
>>
>>
>>
endobj

4 0 obj
<<
/Length 200
>>
stream
BT
/F1 16 Tf
50 750 Td
(Proyecto: {$nombre}) Tj
0 -30 Td
/F1 12 Tf
(Este es un documento PDF de prueba generado automaticamente) Tj
0 -20 Td
(para demostrar la funcionalidad del sistema de proyectos escolares.) Tj
0 -20 Td
(Instituto: Mi Tecnica) Tj
0 -20 Td
(Fecha: " . date('d/m/Y') . ") Tj
ET
endstream
endobj

xref
0 5
0000000000 65535 f
0000000009 00000 n
0000000058 00000 n
0000000115 00000 n
0000000314 00000 n

trailer
<<
/Size 5
/Root 1 0 R
>>
startxref
615
%%EOF";

        // Rellenar para simular archivo más grande (2-3 MB)
        $relleno = str_repeat("\n" . str_repeat("Contenido adicional de prueba para aumentar el tamaño del archivo PDF. ", 50), 800);
        return $contenido . $relleno;
    }

    /**
     * Generar contenido simulado para DOCX
     */
    private function generarDOCXSimulado(string $nombre): string
    {
        $base = "PK\x03\x04\x14\x00\x00\x00\x08\x00";
        $contenido = "Proyecto: {$nombre}\n\n";
        $contenido .= "Instituto: Mi Técnica\n";
        $contenido .= "Este es un documento de Word de prueba.\n\n";
        $contenido .= str_repeat("Párrafo de contenido de ejemplo para documento Word. ", 30) . "\n\n";

        // Simular contenido de 1-2 MB
        for ($i = 1; $i <= 1000; $i++) {
            $contenido .= "Sección {$i}: " . str_repeat("Contenido de ejemplo. ", 20) . "\n";
        }

        return $base . $contenido;
    }

    /**
     * Generar contenido simulado para XLSX
     */
    private function generarXLSXSimulado(string $nombre): string
    {
        $base = "PK\x03\x04\x14\x00\x00\x00\x08\x00";
        $contenido = "Proyecto: {$nombre}\n\n";
        $contenido .= "ID,Nombre,Apellido,Curso,Division,Nota,Asistencia,Fecha\n";

        // Generar 1000 filas de datos
        for ($i = 1; $i <= 1000; $i++) {
            $nota = rand(1, 10);
            $asistencia = rand(60, 100);
            $fecha = date('d/m/Y', strtotime("-{$i} days"));
            $contenido .= "{$i},Alumno{$i},Apellido{$i},{$i}°,A,{$nota},{$asistencia}%,{$fecha}\n";
        }

        return $base . $contenido;
    }

    /**
     * Generar contenido simulado para PPTX
     */
    private function generarPPTXSimulado(string $nombre): string
    {
        $base = "PK\x03\x04\x14\x00\x00\x00\x08\x00";
        $contenido = "Proyecto: {$nombre}\n\n";
        $contenido .= "Presentación de PowerPoint - Instituto Mi Técnica\n\n";

        // Simular 15 diapositivas
        for ($i = 1; $i <= 15; $i++) {
            $contenido .= "═══════════════════════════════════════════\n";
            $contenido .= "DIAPOSITIVA {$i}\n";
            $contenido .= "═══════════════════════════════════════════\n\n";
            $contenido .= "Título: Tema {$i}\n\n";
            $contenido .= str_repeat("• Punto importante sobre el tema {$i}\n", 5);
            $contenido .= "\nNotas del orador:\n";
            $contenido .= str_repeat("Información adicional para el presentador. ", 20) . "\n\n";
        }

        return $base . $contenido;
    }

    /**
     * Generar contenido simulado para ZIP
     */
    private function generarZIPSimulado(string $nombre): string
    {
        $base = "PK\x05\x06";
        $contenido = "\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00";
        $contenido .= "Proyecto comprimido: {$nombre}\n\n";
        $contenido .= "Contenido del archivo ZIP:\n";
        $contenido .= "- documento1.txt\n";
        $contenido .= "- planilla_datos.csv\n";
        $contenido .= "- informe_completo.pdf\n";
        $contenido .= "- imagenes/foto1.jpg\n";
        $contenido .= "- imagenes/foto2.jpg\n\n";

        // Simular archivos comprimidos (5-10 MB)
        for ($i = 1; $i <= 2000; $i++) {
            $contenido .= "Archivo {$i}: " . str_repeat("Datos comprimidos de prueba. ", 30) . "\n";
        }

        return $base . $contenido;
    }
}
