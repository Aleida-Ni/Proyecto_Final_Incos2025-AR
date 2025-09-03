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
public function handle(Request $request, Closure $next, string $roles): Response
{
    if (auth()->check()) {
        $allowedRoles = explode('|', $roles);
        if (in_array(auth()->user()->rol, $allowedRoles)) {
            return $next($request);
        }
    }

    abort(403, 'Acceso no autorizado');
}

}
