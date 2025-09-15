<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== VERIFICACION ESPECÍFICA DE REGISTROS ACTUALIZADOS ===\n";

$hoy = now()->format('Y-m-d');
echo "Fecha de hoy: $hoy\n\n";

// Verificar los registros específicos que aparecen en los logs como actualizados
$registrosEspecificos = DB::table('inasistenciasalumnos')
    ->whereIn('id', [1, 2, 3, 4, 6])
    ->select('id', 'id_asignacionesalumnos', 'cupof', 'estado', 'justificado', 'updated_at')
    ->orderBy('id')
    ->get();

echo "Registros específicos (IDs: 1, 2, 3, 4, 6):\n";
echo str_pad("ID", 5) . str_pad("Asignacion", 12) . str_pad("CUPOF", 8) . str_pad("Estado", 8) . str_pad("Justificado", 12) . str_pad("Updated", 20) . "\n";
echo str_repeat("-", 70) . "\n";

foreach ($registrosEspecificos as $registro) {
    echo str_pad($registro->id, 5) .
        str_pad($registro->id_asignacionesalumnos, 12) .
        str_pad($registro->cupof, 8) .
        str_pad($registro->estado, 8) .
        str_pad($registro->justificado, 12) .
        str_pad($registro->updated_at, 20) . "\n";
}

// Contar todos los justificados de hoy
$todosHoy = DB::table('inasistenciasalumnos')
    ->where('fecha', $hoy)
    ->get();

$justificados = $todosHoy->where('justificado', '1')->count();
$noJustificados = $todosHoy->where('justificado', '0')->count();

echo "\n=== RESUMEN GENERAL ===\n";
echo "Total registros de hoy: " . $todosHoy->count() . "\n";
echo "Registros justificados (1): $justificados\n";
echo "Registros no justificados (0): $noJustificados\n";

// Mostrar los justificados si hay alguno
if ($justificados > 0) {
    echo "\n=== REGISTROS JUSTIFICADOS ===\n";
    $justificadosRegistros = $todosHoy->where('justificado', '1');
    foreach ($justificadosRegistros as $reg) {
        echo "ID: {$reg->id}, Asignación: {$reg->id_asignacionesalumnos}, Estado: {$reg->estado}, Justificado: {$reg->justificado}\n";
    }
}

echo "\n=== FIN VERIFICACION ===\n";
