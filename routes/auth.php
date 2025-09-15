<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('login', 'auth.login')
        ->name('login');

    // Login personalizado para modelo Persona
    Route::get('login-custom', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])
        ->name('login.custom.form');
    Route::post('login-custom', [App\Http\Controllers\Auth\LoginController::class, 'login'])
        ->name('login.custom');

    Volt::route('register', 'auth.register')
        ->name('register');

    Volt::route('forgot-password', 'auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'auth.confirm-password')
        ->name('password.confirm');
});

Route::post('logout', App\Http\Controllers\Auth\LogoutController::class)
    ->name('logout');

// Ruta GET para logout que redirecciona al login (por si alguien accede directamente)
Route::get('logout', function () {
    return redirect()->route('login')->with('info', 'Para cerrar sesión, use el botón correspondiente.');
});

// Ruta de logout alternativa sin CSRF para testing (Laravel 12)
Route::post('logout-alt', App\Http\Controllers\Auth\LogoutController::class)
    ->name('logout.alt')
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
