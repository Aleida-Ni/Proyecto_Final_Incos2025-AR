<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Después del registro, redirige a la página de verificación.
     */
    protected $redirectTo = '/email/verify';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Valida los datos del registro.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre'            => ['required', 'string', 'max:255'],
            'apellido_paterno'  => ['required', 'string', 'max:255'],
            'apellido_materno'  => ['required', 'string', 'max:255'],
            'correo'            => ['required', 'string', 'email', 'max:255', 'unique:users,correo'],
            'telefono'          => ['required', 'string', 'min:7', 'max:15'],
            'fecha_nacimiento'  => ['required', 'date'],
            'contrasenia'        => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Crea un nuevo usuario en la BD.
     */
    protected function create(array $data)
    {
        return User::create([
            'nombre'           => $data['nombre'],
            'apellido_paterno' => $data['apellido_paterno'],
            'apellido_materno' => $data['apellido_materno'],
            'correo'           => $data['correo'],
            'telefono'         => $data['telefono'],
            'fecha_nacimiento' => $data['fecha_nacimiento'],
            'contrasenia'       => Hash::make($data['contrasenia']),
            'rol'              => 'cliente', // por defecto
            'estado'           => 0,         // Por defecto inactivo
        ]);
    }

    /**
     * Sobrescribimos register para enviar nuestra notificación
     * de verificación personalizada.
     */
public function register(Request $request)
{
    // Validar datos
    $this->validator($request->all())->validate();

    // Crear usuario
    $usuario = $this->create($request->all());

    // 🚀 Enviar correo de verificación personalizado
    $usuario->sendEmailVerificationNotification();

    // ✅ Iniciar sesión automáticamente
    $this->guard()->login($usuario);

    // Redirigir según rol (o a verificación de correo)
    return redirect()->route('home')->with('status', '¡Revisa tu correo para verificar tu cuenta!');
}


    /**
     * Para que el login use "correo" en lugar de "email".
     */
    public function username()
    {
        return 'correo';
    }
}
