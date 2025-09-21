<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use App\Models\User;

class VerificationController extends Controller
{
    /**
     * Mostrar aviso de verificación.
     */
    public function notice()
    {
        $user = auth()->user();

        if ($user->rol === 'admin') {
            return redirect()->route('admin');
        }

        if ($user->rol === 'empleado') {
            return redirect()->route('empleado.dashboard');
        }

        // Solo clientes ven la vista de verificación
        return view('auth.verify');
    }

    /**
     * Verificar el correo cuando el usuario da clic en el enlace.
     */
    public function verify(Request $request, $id, $hash)
    {
        $usuario = User::findOrFail($id);

        // Validar hash
        if (! hash_equals(sha1($usuario->getEmailForVerification()), $hash)) {
            return redirect('/login')->with('error', 'Enlace de verificación inválido.');
        }

        // Ya verificado
        if ($usuario->correo_verificado_en) {
            return redirect('/login')->with('status', 'Tu correo ya fue verificado.');
        }

        // Marcar como verificado
        $usuario->correo_verificado_en = now();
        $usuario->estado = 1;
        $usuario->save();

        event(new Verified($usuario));

        // Redirigir según rol
        if ($usuario->rol === 'admin') {
            return redirect()->route('admin');
        } elseif ($usuario->rol === 'empleado') {
            return redirect()->route('empleado.dashboard');
        } else {
            return redirect()->route('cliente.home')->with('status', '¡Correo verificado correctamente!');
        }
    }

    /**
     * Reenviar enlace de verificación.
     */
    public function send(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Se ha enviado un nuevo enlace de verificación a tu correo.');
    }
}
