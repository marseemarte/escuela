<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== ESTRUCTURA DE LA TABLA ===\n";

$estructura = DB::select('DESCRIBE inasistenciasalumnos');

foreach ($estructura as $columna) {
    echo "Columna: " . $columna->Field . "\n";
    echo "  Tipo: " . $columna->Type . "\n";
    echo "  Nulo: " . $columna->Null . "\n";
    echo "  Default: " . $columna->Default . "\n";
    echo "  Extra: " . $columna->Extra . "\n\n";
}

echo "=== TEST DE UPDATE MANUAL ===\n";

// Probar actualizar manualmente un registro
try {
    $resultado = DB::table('inasistenciasalumnos')
        ->where('id', 1)
        ->update(['justificado' => '1']);

    echo "Resultado del UPDATE: $resultado\n";

    // Verificar si se actualizó
    $registro = DB::table('inasistenciasalumnos')
        ->where('id', 1)
        ->select('id', 'justificado')
        ->first();

    echo "Valor después del UPDATE: " . $registro->justificado . "\n";
} catch (Exception $e) {
    echo "Error en UPDATE: " . $e->getMessage() . "\n";
}

echo "\n=== FIN TEST ===\n";
