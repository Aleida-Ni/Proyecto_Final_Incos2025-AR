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
protected function authenticated(Request $request, $user)
{
    if ($user->rol === 'admin' || $user->rol === 'empleado') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('cliente.home');
    }
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
            $this->username() => $request->get($this->username()),
            'password' => $request->get('contrasenia'),
            'correo'   => $request->correo,
            'password' => $request->contrasenia, 
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
