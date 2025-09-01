<?php

use App\Http\Controllers\Profesores\AlumnoController;
use App\Http\Controllers\Profesores\AsistenciaController;
use App\Http\Controllers\Profesores\NotaController;
use App\Http\Controllers\Profesores\ProfesorController;
use App\Http\Controllers\Profesores\TareaController;
use App\Http\Controllers\Profesores\HorariosController;
use App\Http\Controllers\Cursos\CursoController;
use App\Http\Controllers\Materias\MateriasController;
use App\Http\Controllers\Orientaciones\OrientacionesController;
use App\Http\Controllers\RevistaController;
use App\Http\Controllers\CupofController;
use App\Http\Controllers\Orientaciones\ProgramacionController;
use Illuminate\Support\Facades\Route;

use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('app');
})->name('home');

Route::prefix('profesores')->group(function () {
    Route::apiResource('/', ProfesorController::class);

    Route::apiResource('notas', NotaController::class);
    Route::post('notas/materias', [NotaController::class, 'materias'])->name('profesores.notas.materias');
    Route::post('notas/materias/lista', [NotaController::class, 'lista'])->name('profesores.notas.materias.lista');

    Route::apiResource('asistencias', AsistenciaController::class);
    Route::apiResource('tareas', TareaController::class);
    Route::apiResource('alumnos', AlumnoController::class);
    Route::apiResource('horarios', HorariosController::class);
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
//Route::get('/cursos/{curso}', [CursoController::class, 'show'])->name('cursos.show');
Route::get('/cursos/create', [CursoController::class, 'create'])->name('cursos.create');
Route::post('/cursos', [CursoController::class, 'store'])->name('cursos.store');
Route::get('/cursos/{curso}/edit', [CursoController::class, 'edit'])->name('cursos.edit');
Route::put('/cursos/{curso}', [CursoController::class, 'update'])->name('cursos.update');
Route::delete('/cursos/{curso}', [CursoController::class, 'destroy'])->name('cursos.destroy');

// Materias routes
Route::get('/materias', [MateriasController::class, 'index'])->name('materias.index');
// Orientaciones routes
Route::get('/orientaciones', [OrientacionesController::class, 'index'])->name('orientaciones.index');
Route::get('/orientaciones/edit', [OrientacionesController::class, 'edit'])->name('orientaciones.edit');
Route::get('/orientaciones/{id}', [OrientacionesController::class, 'show'])->name('orientaciones.show');

// Materias routes
Route::get('/materias', [MateriasController::class, 'index'])->name('materias.index');
Route::get('/materias/create', [MateriasController::class, 'create'])->name('materias.create');
Route::get('/materias/{id}', [MateriasController::class, 'edit'])->name('materias.edit');



//orientaciones routes
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

// Revista routes (mantener compatibilidad)
Route::get('/revista', [RevistaController::class, 'listarCupofs'])->name('revista.listar');
Route::get('/revista/{cupof}', [RevistaController::class, 'index'])->name('revista.index');

require __DIR__ . '/auth.php';


// Revista routes (mantener compatibilidad)
Route::get('/revista', [RevistaController::class, 'listarCupofs'])->name('revista.listar');
Route::get('/revista/{cupof}', [RevistaController::class, 'index'])->name('revista.index');
Route::view('/mmo', 'orientaciones.mmo.index')->name('mmo.index');
Route::view('/ciclo_basico', 'orientaciones.ciclo_basico.index')->name('ciclo_basico.index');
Route::view('/turismo', 'orientaciones.turismo.index')->name('turismo.index');
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

// Revista routes (mantener compatibilidad)
Route::get('/revista', [RevistaController::class, 'listarCupofs'])->name('revista.listar');
Route::get('/revista/{cupof}', [RevistaController::class, 'index'])->name('revista.index');

require __DIR__ . '/auth.php';

Route::put('/materias/{materia}/cambiar-orientacion', [MateriasController::class, 'cambiarOrientacion'])->name('materias.cambiar_orientacion');
