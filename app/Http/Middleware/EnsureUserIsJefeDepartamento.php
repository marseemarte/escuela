<?php
// filepath: app/Http/Middleware/EnsureUserIsJefeDepartamento.php

namespace App\Http\Middleware;

use App\Models\Departamento;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsJefeDepartamento
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión');
        }

        $user = Auth::user();

        // Verificar si el usuario es Profesor y es Jefe de Departamento
        $tipoUsuario = $user->tiposUsuario()
            ->whereHas('tipoPersona', fn($q) => $q->where('tipo', 'Profesor'))
            ->first();

        if (!$tipoUsuario) {
            return redirect()->route('home')->with('error', 'No tiene permisos de Profesor');
        }

        // Verificar si es jefe de algún departamento
        $esJefeDepartamento = Departamento::where('id_tipousuario', $tipoUsuario->id)
            ->where('estado', 'A')
            ->exists();

        if (!$esJefeDepartamento) {
            return redirect()->route('home')->with('error', 'No es jefe de ningún departamento');
        }

        return $next($request);
    }
}
