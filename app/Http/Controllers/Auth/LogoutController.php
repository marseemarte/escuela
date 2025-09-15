<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogoutController extends Controller
{
    /**
     * Log the user out of the application.
     */
    public function __invoke(Request $request)
    {
        try {
            Log::info('Logout attempt started', [
                'user_id' => Auth::id(),
                'session_id' => $request->session()->getId(),
                'csrf_token' => $request->input('_token'),
                'session_token' => $request->session()->token()
            ]);

            // Verificar que el usuario esté autenticado
            if (Auth::check()) {
                Auth::guard('web')->logout();
                Log::info('User logged out successfully');
            }

            // Invalidar sesión y regenerar token
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Log::info('Session invalidated and token regenerated');

            return redirect('/')->with('success', 'Sesión cerrada exitosamente');
        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return redirect('/')->with('error', 'Error al cerrar sesión');
        }
    }
}
