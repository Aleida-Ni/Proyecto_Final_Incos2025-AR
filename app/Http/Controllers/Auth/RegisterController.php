<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
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
            'contraseña'        => ['required', 'string', 'min:8', 'confirmed'],
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
            'contraseña'       => Hash::make($data['contraseña']),
            'rol'              => 'cliente', // por defecto
        ]);
    }

    /**
     * Sobrescribimos register para disparar el evento Registered
     * y que Laravel mande el correo de verificación.
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $usuario = $this->create($request->all());

        // 🚀 Aquí Laravel manda el correo de verificación automáticamente
        event(new Registered($usuario));

        // Ojo: No iniciamos sesión hasta que confirme el correo
        return redirect($this->redirectPath())
            ->with('status', '¡Revisa tu correo para verificar tu cuenta antes de iniciar sesión!');
    }

    /**
     * Para que el login use "correo" en lugar de "email".
     */
    public function username()
    {
        return 'correo';
    }
}
