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

        if (! $user || ! method_exists($user, 'isProfesor') || ! $user->isProfesor()) {
            abort(403, 'Acceso restringido a profesores');
        }

        return $next($request);
    }
}
