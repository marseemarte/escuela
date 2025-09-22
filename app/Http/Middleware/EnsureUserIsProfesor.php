<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsProfesor
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Debug temporal
        if ($request->has('debug_middleware')) {
            return response()->json([
                'middleware' => 'EnsureUserIsProfesor',
                'user_exists' => $user ? true : false,
                'user_id' => $user ? $user->id : null,
                'has_isProfesor_method' => $user ? method_exists($user, 'isProfesor') : false,
                'is_profesor' => $user && method_exists($user, 'isProfesor') ? $user->isProfesor() : false,
                'url' => $request->url()
            ]);
        }

        if (! $user || ! method_exists($user, 'isProfesor') || ! $user->isProfesor()) {
            abort(403, 'Acceso restringido a profesores');
        }

        return $next($request);
    }
}
