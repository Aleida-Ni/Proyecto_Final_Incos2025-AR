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


    protected $redirectTo = '/email/verify';

    protected function redirectTo()
{
    return route('verification.notice');
}

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
            'nombre' => ['required', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,30}$/'],
            'apellido_paterno' => ['required', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,30}$/'],
            'apellido_materno' => ['required', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,30}$/'],
            'correo'            => ['required', 'string', 'email', 'max:255', 'unique:usuarios,correo'],
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
            'rol'              => 'cliente', 
            'estado'           => 0,         
        ]);
    }

    /**
     * Sobrescribimos register para enviar nuestra notificación
     * de verificación personalizada.
     */
public function register(Request $request)
{
    $this->validator($request->all())->validate();

    $usuario = $this->create($request->all());

    $usuario->sendEmailVerificationNotification();

    $this->guard()->login($usuario);

    return $this->registered($request, $usuario)
        ?: redirect($this->redirectPath());
}


    /**
     * Para que el login use "correo" en lugar de "email".
     */
    public function username()
    {
        return 'correo';
    }
}