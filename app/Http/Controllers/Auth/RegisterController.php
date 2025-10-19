<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
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
        // Validación: cada palabra debe tener al menos 2 letras y longitud total 2..30
        $nameRegex = '/^(?=.{2,30}$)(?:[A-Za-zÁÉÍÓÚáéíóúÑñ]{2,}(?:\s+[A-Za-zÁÉÍÓÚáéíóúÑñ]{2,})*)$/u';

        return Validator::make($data, [
            'nombre' => ['required', "regex:$nameRegex"],
            'apellido_paterno' => ['required', "regex:$nameRegex"],
            'apellido_materno' => ['required', "regex:$nameRegex"],
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
        return Usuario::create([
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
        // Sanear entradas: trim y colapsar espacios en campos de nombre
        $input = $request->all();
        $nameFields = ['nombre', 'apellido_paterno', 'apellido_materno'];
        foreach ($nameFields as $f) {
            if (isset($input[$f]) && is_string($input[$f])) {
                // trim y reemplazar múltiples espacios por uno
                $clean = preg_replace('/\s+/u', ' ', trim($input[$f]));
                $input[$f] = $clean;
            }
        }

        // También sanear correo y teléfono básicos
        if (isset($input['correo']) && is_string($input['correo'])) {
            $input['correo'] = trim(mb_strtolower($input['correo']));
        }
        if (isset($input['telefono']) && is_string($input['telefono'])) {
            $input['telefono'] = trim($input['telefono']);
        }

        // Validar sobre los datos saneados
        $this->validator($input)->validate();

        $usuario = $this->create($input);

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