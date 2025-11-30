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
use App\Http\Controllers\Departamentos\DepartamentoController;
use App\Http\Controllers\Profesores\AsistenciaController;
use App\Http\Controllers\Profesores\PlanificacionController;
use App\Http\Controllers\Profesores\ProyectoController;
use App\Http\Middleware\EnsureUserIsJefeDepartamento;
use App\Http\Middleware\EnsureUserIsProfesor;
use Illuminate\Support\Facades\Route;

use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('app');
})->name('home');
Route::prefix('departamento')->middleware(['auth', EnsureUserIsJefeDepartamento::class])->name('departamento.')->group(function () {

    // Ruta principal de jefes de departamento
    Route::get('/', [DepartamentoController::class, 'index'])->name('index');

    // Ruta para gestión de materias del departamento
    Route::get('/materias', [DepartamentoController::class, 'materias'])->name('materias');

    // Ruta para ver profesores del departamento
    Route::get('/profesores', [DepartamentoController::class, 'profesores'])->name('profesores');

    // Ruta para ver proyectos del departamento
    Route::get('/proyectos', [DepartamentoController::class, 'proyectos'])->name('proyectos');

    // Ruta para ver planificaciones del departamento
    Route::get('/planificaciones', [DepartamentoController::class, 'planificaciones'])->name('planificaciones');
});

Route::prefix('profesores')->middleware(['auth', EnsureUserIsProfesor::class])->name('profesores.')->group(function () {

    // Ruta principal de profesores
    Route::get('/', [ProfesorController::class, 'index'])->name('index');

    // Sección de Tareas
    Route::prefix('tareas')->name('tareas.')->group(function () {
        Route::get('/', [TareaController::class, 'index'])->name('index');
        Route::post('/', [TareaController::class, 'store'])->name('store');
        Route::get('corregir', [TareaController::class, 'corregir'])->name('corregir');
        Route::get('{id}/descargar', [TareaController::class, 'descargar'])->name('descargar');
        Route::get('{id}/seguimiento', [TareaController::class, 'seguimiento'])->name('seguimiento');
        Route::delete('{id}', [TareaController::class, 'destroy'])->name('destroy');
        Route::get('{cupof}', [TareaController::class, 'cargar'])->name('cargar');
        Route::get('{id}/corregir', [CorregirTareaController::class, 'index'])->name('corregir');
        Route::post('guardar-correccion', [CorregirTareaController::class, 'guardar'])->name('guardar-correccion');
        Route::post('eliminar-correccion', [CorregirTareaController::class, 'eliminar'])->name('eliminar-correccion');
        Route::get('alumno/{tareaAlumnoId}/descargar', [CorregirTareaController::class, 'descargarRespuesta'])->name('descargar-respuesta');
    });

    // Sección de Informes
    Route::controller(NotaController::class)->prefix('informes')->name('informes.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('{cupof}', 'cargar')->name('cargar');
        Route::get('totales/{cupof}', 'totales')->name('totales');
        Route::post('guardar', 'guardarNotas')->name('guardar');
    });

    // Rutas específicas de asistencias
    Route::controller(AsistenciaController::class)->prefix('asistencias')->name('asistencias.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('tomar/{cupof}', 'tomar')->name('tomar');
        Route::post('guardar', 'guardarAsistencia')->name('guardar');
        Route::get('totales/{cupof}', 'totales')->name('totales');
        Route::get('alumnos/{cupof}', 'obtenerAlumnos')->name('alumnos');
    });
    // Rutas de planificación
    Route::controller(PlanificacionController::class)->prefix('planificaciones')->name('planificaciones.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{cupof}', 'cargar')->name('cargar');
        Route::post('/guardar', 'guardar')->name('guardar');
        Route::delete('/{id}', 'eliminar')->name('eliminar');
        Route::get('/descargar/{id}', 'descargar')->name('descargar');
    });

    // Rutas de proyectos
    Route::controller(ProyectoController::class)->prefix('proyectos')->name('proyectos.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/cargar/{cupof}', 'cargar')->name('cargar');
        Route::post('/guardar', 'guardar')->name('guardar');
        Route::delete('/eliminar/{id}', 'eliminar')->name('eliminar');
        Route::get('/descargar/{id}', 'descargar')->name('descargar');
    });

    // Rutas de horarios
    Route::controller(HorariosController::class)->prefix('horarios')->name('horarios.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
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
