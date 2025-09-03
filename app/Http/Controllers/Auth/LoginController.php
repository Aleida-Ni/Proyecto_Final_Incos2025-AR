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
     * Modificar validación de login para usar "contraseña".
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'contrasenia' => 'required|string',
        ]);
    }

    /**
     * Modificar intento de login para usar "contraseña".
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    /**
     * Cambiar credenciales para usar "contraseña".
     */
    protected function credentials(Request $request)
    {
        return [
            $this->username() => $request->get($this->username()),
            'password' => $request->get('contrasenia'),
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
