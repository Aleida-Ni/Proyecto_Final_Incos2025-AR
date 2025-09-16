<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Manejar la solicitud entrante.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            // Si el rol del usuario está en la lista permitida
            if (in_array($user->rol, $roles)) {
                // Si es cliente, debe tener estado = 1
                if ($user->rol === 'cliente' && $user->estado != 1) {
                    abort(403, 'Debes verificar tu cuenta primero.');
                }
                return $next($request);
            }

            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return redirect()->route('login');
    }
}
