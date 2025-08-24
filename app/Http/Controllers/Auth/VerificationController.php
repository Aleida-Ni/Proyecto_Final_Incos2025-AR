<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use App\Models\User;

class VerificationController extends Controller
{
    /**
     * Muestra aviso de verificación.
     */
    public function notice()
    {
        return view('auth.verify'); // crea esta vista para decir "Revisa tu correo"
    }

    /**
     * Verifica el correo cuando el usuario da clic en el enlace.
     */
    public function verify(Request $request, $id, $hash)
    {
        $usuario = User::findOrFail($id);

        // Verificamos que el hash sea válido
        if (! hash_equals(sha1($usuario->getEmailForVerification()), $hash)) {
            return redirect('/login')->with('error', 'Enlace de verificación inválido.');
        }

        // Si ya está verificado, redirige
        if ($usuario->correo_verificado_en) {
            return redirect('/login')->with('status', 'Tu correo ya fue verificado.');
        }

        // Marca el correo como verificado
        $usuario->correo_verificado_en = now();
        $usuario->estado = 1; // activa al usuario
        $usuario->save();

        event(new Verified($usuario));

        return redirect('/login')->with('status', '¡Correo verificado correctamente! Ya puedes iniciar sesión.');
    }

    public function show()
    {
        return view('auth.verify');
    }
    public function send(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Se ha enviado un nuevo enlace de verificación a tu correo.');
    }
}
