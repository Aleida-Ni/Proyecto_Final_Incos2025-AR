<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
public function handle(Request $request, Closure $next)
{
    if (auth()->check()) {
        $user = auth()->user();

        // Si es cliente, debe tener estado = 1
        if ($user->rol === 'cliente' && $user->estado != 1) {
            abort(403, 'Debes verificar tu cuenta primero.');
        }
    }

    return $next($request);
}



}