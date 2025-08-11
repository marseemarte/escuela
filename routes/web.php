<?php

use App\Http\Controllers\Profesores\AlumnoController;
use App\Http\Controllers\Profesores\AsistenciaController;
use App\Http\Controllers\Profesores\NotaController;
use App\Http\Controllers\Profesores\ProfesorController;
use App\Http\Controllers\Profesores\TareaController;
use App\Http\Controllers\Cursos\CursoController;
use App\Http\Controllers\Materias\MateriasController;
use App\Http\Controllers\Orientaciones\OrientacionesController;
use App\Http\Controllers\RevistaController;
use App\Http\Controllers\CupofController;
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

// Materias routes
Route::get('/materias', [MateriasController::class, 'index'])->name('materias.index');

//orientaciones routes
Route::get('/programacion', [ProgramacionController::class, 'index'])->name('programacion.index');
Route::get('/programacion/edit', [ProgramacionController::class, 'edit'])->name('programacion.edit');
Route::put('/programacion/{programacion}', [ProgramacionController::class, 'update'])->name('programacion.update');

Route::view('/mmo', 'orientaciones.mmo.index')->name('mmo.index');
Route::view('/ciclo_basico', 'orientaciones.ciclo_basico.index')->name('ciclo_basico.index');
Route::view('/turismo', 'orientaciones.turismo.index')->name('turismo.index');

require __DIR__ . '/auth.php';
