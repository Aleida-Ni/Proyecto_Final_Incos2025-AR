<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarEstado
{
    /**
     * Handle an incoming request.
     */
public function handle(Request $request, Closure $next)
{
    $user = $request->user();

    if ($user && $user->estado == 0) {
        // Si es cliente con estado 0 → mandarlo a verificar email
        if ($user->rol === 'cliente') {
            return redirect()->route('verification.notice');
        }

        // Si es admin o empleado inactivo → logout
        auth()->logout();
        return redirect()->route('login')
            ->withErrors(['estado' => 'Tu cuenta está inactiva. Contacta al administrador.']);
    }

    return $next($request);
}
protected function verificationUrl($notifiable)
{
    return url('/email/verificar/' . $notifiable->id . '/' . sha1($notifiable->correo));
}

}
