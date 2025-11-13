<?php
// filepath: app/Http/Middleware/EnsureUserIsJefeDepartamento.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        // Verificar si el usuario es Jefe de Departamento
        $esJefeDepartamento = DB::table('tipousuario')
            ->join('tipopersona', 'tipousuario.id_tipopersona', '=', 'tipopersona.id')
            ->where('tipousuario.id_persona', $user->id)
            ->where('tipopersona.tipo', 'Jefe de Departamento')
            ->exists();

        if (!$esJefeDepartamento) {
            return redirect()->route('home')->with('error', 'No tiene permisos para acceder a esta sección');
        }

        return $next($request);
    }
}
