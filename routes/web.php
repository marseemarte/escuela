<?php

use App\Http\Controllers\Profesores\AlumnoController;
use App\Http\Controllers\Profesores\AsistenciaController;
use App\Http\Controllers\Profesores\NotaController;
use App\Http\Controllers\Profesores\ProfesorController;
use App\Http\Controllers\Profesores\TareaController;
use App\Http\Controllers\Cursos\CursoController;
use Illuminate\Support\Facades\Route;

use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('app');
})->name('home');

Route::prefix('profesores')->group(function () {
    Route::apiResource('/', ProfesorController::class);
    Route::apiResource('notas', NotaController::class);
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

require __DIR__ . '/auth.php';
