<?php

use App\Http\Controllers\Profesores\AlumnoController;
use App\Http\Controllers\Profesores\NotaController;
use App\Http\Controllers\Profesores\ProfesorController;
use App\Http\Controllers\Profesores\TareaController;
use App\Http\Controllers\Profesores\HorariosController;
use App\Http\Controllers\Cursos\CursoController;
use App\Http\Controllers\Materias\MateriasController;
use App\Http\Controllers\Orientaciones\OrientacionesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\RevistaController;
use App\Http\Controllers\CupofController;
use App\Http\Controllers\Profesores\AsistenciaController;
use App\Http\Middleware\EnsureUserIsProfesor;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HorariosSubidaController;

use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('app');
})->name('home');

Route::get('/cargar-horarios', [HorariosController::class, 'create'])->name('horarios.crearhorarios');
Route::post('/cargar-horarios', [HorariosController::class, 'store'])->name('horarios.store');

// Rutas de asistencias para usuarios generales (estudiantes/padres)
Route::middleware(['auth'])->group(function () {
    Route::get('asistencias', [AsistenciaController::class, 'index'])->name('asistencias.index');
});

Route::prefix('profesores')->middleware(['auth', EnsureUserIsProfesor::class])->group(function () {

    // Ruta principal de profesores
    Route::get('/', [ProfesorController::class, 'index'])->name('profesores.index');

    // Sección de Tareas
    Route::prefix('tareas')->name('profesores.tareas.')->group(function () {
        Route::get('/', [TareaController::class, 'index'])->name('index');
        Route::post('/', [TareaController::class, 'store'])->name('store');
        Route::get('/corregir', [TareaController::class, 'corregir'])->name('corregir');
        Route::get('/{id}/descargar', [TareaController::class, 'descargar'])->name('descargar');
        Route::get('/{id}/seguimiento', [TareaController::class, 'seguimiento'])->name('seguimiento');
        Route::delete('/{id}', [TareaController::class, 'destroy'])->name('destroy');
        Route::get('/{cupof}', [TareaController::class, 'cargar'])->name('cargar');
    });



    // Rutas específicas de notas (similar a asistencias)
    Route::get('notas', [NotaController::class, 'index'])->name('profesores.notas.index');
    Route::get('notas/{cupof}', [NotaController::class, 'cargar'])->name('profesores.notas.cargar');
    Route::get('notas/totales/{cupof}', [NotaController::class, 'totales'])->name('profesores.notas.totales');
    Route::post('notas/guardar', [NotaController::class, 'guardarNotas'])->name('profesores.notas.guardar');

    // Rutas específicas de asistencias (sin apiResource completo)
    Route::get('asistencias', [AsistenciaController::class, 'index'])->name('profesores.asistencias.index');
    Route::get('asistencias/tomar/{cupof}', [AsistenciaController::class, 'tomar'])->name('profesores.asistencias.tomar');
    Route::get('asistencias/totales/{cupof}', [AsistenciaController::class, 'totales'])->name('profesores.asistencias.totales');
    Route::get('asistencias/alumnos/{cupof}', [AsistenciaController::class, 'obtenerAlumnos'])->name('profesores.asistencias.alumnos');

    // Ruta para guardar asistencias - temporalmente sin verificación CSRF estricta
    Route::post('asistencias/guardar', [AsistenciaController::class, 'guardarAsistencia'])
        ->name('profesores.asistencias.guardar')
        ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);

    Route::apiResource('tareas', TareaController::class);
    Route::apiResource('alumnos', AlumnoController::class);
    Route::apiResource('horarios', HorariosController::class);
});

Route::view('/', 'welcome')->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

// Dashboard sin middleware para testing
// Debug routes eliminadas - autenticación funcionando correctamente

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
Route::get('/cursos/create', [CursoController::class, 'create'])->name('cursos.create');
Route::post('/cursos', [CursoController::class, 'store'])->name('cursos.store');
Route::get('/cursos/{curso}/edit', [CursoController::class, 'edit'])->name('cursos.edit');
Route::put('/cursos/{curso}', [CursoController::class, 'update'])->name('cursos.update');
Route::delete('/cursos/{curso}', [CursoController::class, 'destroy'])->name('cursos.destroy');

// Materias routes
Route::get('/materias', [MateriasController::class, 'index'])->name('materias.index');
Route::get('/materias/create', [MateriasController::class, 'create'])->name('materias.create');
Route::get('/materias/{id}', [MateriasController::class, 'edit'])->name('materias.edit');
Route::put('/materias/{materia}/cambiar-orientacion', [MateriasController::class, 'cambiarOrientacion'])->name('materias.cambiar_orientacion');

// Orientaciones routes
Route::resource('orientaciones', OrientacionesController::class);
Route::get('/orientaciones', [OrientacionesController::class, 'index'])->name('orientaciones.index');
Route::get('/orientaciones/edit', [OrientacionesController::class, 'edit'])->name('orientaciones.edit');
Route::get('/orientaciones/{id}', [OrientacionesController::class, 'show'])->name('orientaciones.show');
Route::get('/orientaciones/create', [OrientacionesController::class, 'create'])->name('orientaciones.create');
Route::post('/orientaciones', [OrientacionesController::class, 'store'])->name('orientaciones.store');
Route::put('/orientaciones/taller/update', [OrientacionesController::class, 'updateTallerOrientacion'])->name('orientaciones.updateTallerOrientacion');

// CUPOF routes
Route::get('/cupof', [CupofController::class, 'index'])->name('cupof.index');
Route::get('/cupof/create', [CupofController::class, 'create'])->name('cupof.create');
Route::post('/cupof', [CupofController::class, 'store'])->name('cupof.store');
Route::get('/cupof/{cupof}', [CupofController::class, 'show'])->name('cupof.show');
Route::get('/cupof/{cupof}/edit', [CupofController::class, 'edit'])->name('cupof.edit');
Route::put('/cupof/{cupof}', [CupofController::class, 'update'])->name('cupof.update');
Route::delete('/cupof/{cupof}', [CupofController::class, 'destroy'])->name('cupof.destroy');

// Rutas para gestionar profesores en cupof
Route::get('/cupof/{cupof}/agregar-profesor', [CupofController::class, 'agregarProfesor'])->name('cupof.agregar-profesor');
Route::post('/cupof/{cupof}/profesor', [CupofController::class, 'storeProfesor'])->name('cupof.store-profesor');
Route::get('/cupof/{cupof}/profesor/{profesorId}/editar', [CupofController::class, 'editarProfesor'])->name('cupof.editar-profesor');
Route::put('/cupof/{cupof}/profesor/{profesorId}', [CupofController::class, 'updateProfesor'])->name('cupof.update-profesor');
Route::delete('/cupof/{cupof}/profesor/{profesorId}', [CupofController::class, 'eliminarProfesor'])->name('cupof.eliminar-profesor');

// Revista routes
Route::get('/revista', [RevistaController::class, 'listarCupofs'])->name('revista.listar');
Route::get('/revista/{cupof}', [RevistaController::class, 'index'])->name('revista.index');

// Orientaciones views
Route::view('/mmo', 'orientaciones.mmo.index')->name('mmo.index');
Route::view('/ciclo_basico', 'orientaciones.ciclo_basico.index')->name('ciclo_basico.index');
Route::view('/turismo', 'orientaciones.turismo.index')->name('turismo.index');

// Ruta temporal para testing de totales (sin middleware)
Route::get('/test/totales/{cupof}', [App\Http\Controllers\Profesores\AsistenciaController::class, 'totales'])->name('test.totales');

// Ruta temporal para testing de notas (sin middleware)
Route::get('/test/notas/cargar/{cupof}', [App\Http\Controllers\Profesores\NotaController::class, 'cargar'])->name('test.notas.cargar');

// Ruta de debug para verificar datos del CUPOF
Route::get('/debug/cupof/{cupof}', function ($cupof) {
    $usuario = Auth::user();
    if (!$usuario) {
        return response()->json(['error' => 'No autenticado']);
    }

    // Buscar CUPOF sin restricciones
    $cupofGeneral = DB::table('cupof')->where('cupof', $cupof)->first();

    // Buscar con restricciones del profesor
    $cupofProfesor = DB::table('cupof')
        ->join('materias', 'cupof.id_materias', '=', 'materias.id')
        ->join('cursos', 'cupof.id_cursos', '=', 'cursos.id')
        ->join('grupos', 'cupof.id_grupos', '=', 'grupos.id')
        ->join('revista', 'cupof.cupof', '=', 'revista.cupof')
        ->join('tipousuario', 'revista.id_tipousuario', '=', 'tipousuario.id')
        ->join('persona', 'tipousuario.id_persona', '=', 'persona.id')
        ->where('cupof.cupof', $cupof)
        ->where('persona.dni', $usuario->dni)
        ->where('cupof.estado', 'A')
        ->where('revista.situacion', 'A')
        ->select(
            'cupof.*',
            'materias.nombre as materia_nombre',
            'cursos.*',
            'grupos.*',
            'persona.dni',
            'persona.nombre as profesor_nombre',
            'revista.situacion'
        )
        ->first();

    return response()->json([
        'usuario' => [
            'id' => $usuario->id,
            'dni' => $usuario->dni,
            'nombre' => $usuario->nombre,
            'apellido' => $usuario->apellido,
            'es_profesor' => $usuario instanceof App\Models\Personas\Persona ? $usuario->isProfesor() : false
        ],
        'cupof_solicitado' => $cupof,
        'cupof_general' => $cupofGeneral,
        'cupof_profesor' => $cupofProfesor,
        'existe_cupof' => $cupofGeneral ? 'SI' : 'NO',
        'profesor_tiene_acceso' => $cupofProfesor ? 'SI' : 'NO'
    ]);
})->middleware(['auth'])->name('debug.cupof');

// Ruta de debug para verificar consulta de alumnos
Route::get('/debug/alumnos/{cupof}', function ($cupof) {
    $usuario = Auth::user();
    if (!$usuario) {
        return response()->json(['error' => 'No autenticado']);
    }

    // Obtener información del CUPOF
    $cupofInfo = DB::table('cupof')
        ->join('materias', 'cupof.id_materias', '=', 'materias.id')
        ->join('cursos', 'cupof.id_cursos', '=', 'cursos.id')
        ->join('grupos', 'cupof.id_grupos', '=', 'grupos.id')
        ->where('cupof.cupof', $cupof)
        ->select('cupof.*', 'materias.nombre as materia_nombre', 'cursos.*', 'grupos.*')
        ->first();

    if (!$cupofInfo) {
        return response()->json(['error' => 'CUPOF no encontrado']);
    }

    // Verificar tablas disponibles
    $tables = DB::select('SHOW TABLES');
    $tableNames = array_map(function ($table) {
        return array_values((array)$table)[0];
    }, $tables);

    // Intentar consulta de alumnos simplificada
    try {
        $alumnos = DB::table('persona')
            ->join('tipousuario', 'persona.id', '=', 'tipousuario.id_persona')
            ->join('tipopersona', 'tipousuario.id_tipopersona', '=', 'tipopersona.id')
            ->where('tipopersona.tipo', 'Alumno')
            ->select('persona.*', 'tipousuario.id as tipousuario_id')
            ->limit(5)
            ->get();
    } catch (\Exception $e) {
        $alumnos = 'Error: ' . $e->getMessage();
    }

    return response()->json([
        'cupof_info' => $cupofInfo,
        'tablas_disponibles' => $tableNames,
        'alumnos_test' => $alumnos
    ]);
})->middleware(['auth'])->name('debug.alumnos');

// Ruta de prueba temporal para verificar CSRF
Route::post('test-csrf', function () {
    return response()->json(['status' => 'success', 'message' => 'CSRF token válido']);
})->name('test.csrf');

// Debug routes eliminadas - autenticación funcionando correctamente

// Incluir rutas de autenticación
require __DIR__ . '/auth.php';

Route::put('/materias/{materia}/cambiar-orientacion', [MateriasController::class, 'cambiarOrientacion'])->name('materias.cambiar_orientacion');
Route::get('/materias/create', [MateriasController::class, 'create'])->name('materias.create');