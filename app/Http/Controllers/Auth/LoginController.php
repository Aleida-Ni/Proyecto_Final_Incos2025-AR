<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirección después de login según rol.
     */
    protected function authenticated($request, $user)
    {
        if ($user->rol === 'admin') {
            return redirect('/admin');
        } elseif ($user->rol === 'empleado') {
            return redirect('/empleado');
        }

        return redirect('/home'); // cliente
    }

    /**
     * Usar "correo" en vez de "email" para login.
     */
    public function username()
    {
        return 'correo';
    }

    /**
     * Validar login con "contrasenia".
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'contrasenia' => 'required|string',
        ]);
    }

    /**
     * Usar credenciales traduciendo "contrasenia" a "password".
     */
    protected function credentials(Request $request)
    {
        return [
            'correo'   => $request->correo,
            'password' => $request->contrasenia, // 👈 siempre "password"
        ];
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
