<?php

use App\Http\Controllers\Profesores\NotaController;
use App\Http\Controllers\Profesores\ProfesorController;
use App\Http\Controllers\Profesores\TareaController;
use App\Http\Controllers\Profesores\CorregirTareaController;
use App\Http\Controllers\Profesores\HorariosController;
use App\Http\Controllers\Cursos\CursoController;
use App\Http\Controllers\Materias\MateriasController;
use App\Http\Controllers\Orientaciones\OrientacionesController;
use App\Http\Controllers\RevistaController;
use App\Http\Controllers\CupofController;
use App\Http\Controllers\Profesores\AsistenciaController;
use App\Http\Middleware\EnsureUserIsProfesor;
use Illuminate\Support\Facades\Route;

use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('app');
})->name('home');



Route::get('/profesores/horarios/create', [HorariosController::class, 'create'])
    ->name('horarios.create');

Route::post('/profesores/horarios', [HorariosController::class, 'store'])
    ->name('horarios.store');
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
        Route::get('{id}/corregir', [CorregirTareaController::class, 'index'])->name('corregir');
        Route::post('guardar-correccion', [CorregirTareaController::class, 'guardar'])->name('guardar-correccion');
        Route::post('eliminar-correccion', [CorregirTareaController::class, 'eliminar'])->name('eliminar-correccion');
        Route::get('alumno/{tareaAlumnoId}/descargar', [CorregirTareaController::class, 'descargarRespuesta'])->name('descargar-respuesta');
    });

    // Sección de Informes
    Route::prefix('informes')->name('profesores.informes.')->group(function () {
        Route::get('/', [NotaController::class, 'index'])->name('index');
        Route::get('{cupof}', [NotaController::class, 'cargar'])->name('cargar');
        Route::get('totales/{cupof}', [NotaController::class, 'totales'])->name('totales');
        Route::post('guardar', [NotaController::class, 'guardarNotas'])->name('guardar');
    });

    // Rutas específicas de asistencias
    Route::prefix('asistencias')->name('profesores.asistencias.')->group(function () {
        Route::get('/', [AsistenciaController::class, 'index'])->name('index');
        Route::get('tomar/{cupof}', [AsistenciaController::class, 'tomar'])->name('tomar');
        Route::post('guardar', [AsistenciaController::class, 'guardarAsistencia'])->name('guardar');
        Route::get('totales/{cupof}', [AsistenciaController::class, 'totales'])->name('totales');
        Route::get('alumnos/{cupof}', [AsistenciaController::class, 'obtenerAlumnos'])->name('alumnos');
    });

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
Route::post('/materias', [MateriasController::class, 'store'])->name('materias.store');
Route::put('/materias/{materia}', [MateriasController::class, 'update'])->name('materias.update');
Route::delete('/materias/{materia}', [MateriasController::class, 'destroy'])->name('materias.destroy');

// Orientaciones routes
Route::resource('orientaciones', OrientacionesController::class);
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

// Incluir rutas de autenticación
require __DIR__ . '/auth.php';

Route::put('/materias/{materia}/cambiar-orientacion', [MateriasController::class, 'cambiarOrientacion'])->name('materias.cambiar_orientacion');
Route::get('/materias/create', [MateriasController::class, 'create'])->name('materias.create');
