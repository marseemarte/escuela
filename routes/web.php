<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\ProfesoresController;

Route::get('/', function () {
    return view('app');
})->name('home');
Route::get('/administracion/profesores/{seccion?}', [ProfesoresController::class, 'index'])
    ->where('seccion', 'inicio|notas|asistencias|tareas|alumnos')
    ->name('profesores.seccion');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
