<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== VERIFICACION DE CHECKBOXES JUSTIFICADOS ===\n";

// Verificar registros de asistencias de hoy
$hoy = now()->format('Y-m-d');
echo "Fecha de hoy: $hoy\n\n";

$asistencias = DB::table('inasistenciasalumnos')
    ->where('fecha', $hoy)
    ->select('id', 'id_asignacionesalumnos', 'cupof', 'estado', 'justificado')
    ->orderBy('id_asignacionesalumnos')
    ->get();

echo "Total de registros de asistencias de hoy: " . $asistencias->count() . "\n";

if ($asistencias->count() > 0) {
    echo "\nUltimos 5 registros:\n";
    echo str_pad("ID", 5) . str_pad("Asignacion", 12) . str_pad("CUPOF", 8) . str_pad("Estado", 8) . str_pad("Justificado", 12) . "\n";
    echo str_repeat("-", 50) . "\n";

    foreach ($asistencias->take(5) as $asistencia) {
        echo str_pad($asistencia->id, 5) .
            str_pad($asistencia->id_asignacionesalumnos, 12) .
            str_pad($asistencia->cupof, 8) .
            str_pad($asistencia->estado, 8) .
            str_pad($asistencia->justificado, 12) . "\n";
    }

    // Contar justificados
    $justificados = $asistencias->where('justificado', '1')->count();
    echo "\nRegistros con justificado = '1': $justificados\n";
    echo "Registros con justificado = '0': " . ($asistencias->count() - $justificados) . "\n";
}

echo "\n=== FIN VERIFICACION ===\n";
