<?php

use App\Http\Controllers\Profesores\AlumnoController;
use App\Http\Controllers\Profesores\AsistenciaController;
use App\Http\Controllers\Profesores\NotaController;
use App\Http\Controllers\Profesores\ProfesorController;
use App\Http\Controllers\Profesores\TareaController;
use App\Http\Controllers\Cursos\CursoController;
use App\Http\Controllers\Materias\MateriasController;
use App\Http\Controllers\Orientaciones\OrientacionesController;
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


require __DIR__ . '/auth.php';
