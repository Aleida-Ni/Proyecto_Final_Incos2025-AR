<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\EmpleadoPasswordMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = User::where('rol', 'empleado')->get(); 
        return view('admin.empleados.index', compact('empleados'));
    }

    public function create()
    {
        return view('admin.empleados.create');
    }

public function store(Request $request)
{
    // Validar datos
    $request->validate([
        'nombre' => 'required',
        'apellido_paterno' => 'required',
        'apellido_materno' => 'required',
        'correo' => 'required|email|unique:users,correo',
    ]);

    // Generar contraseña aleatoria
    $password = Str::random(8);

    // Crear empleado
    $empleado = new User();
    $empleado->nombre = $request->nombre;
    $empleado->apellido_paterno = $request->apellido_paterno;
    $empleado->apellido_materno = $request->apellido_materno;
    $empleado->correo = $request->correo;
    $empleado->telefono = $request->telefono;
    $empleado->fecha_nacimiento = $request->fecha_nacimiento;
    $empleado->contrasenia = Hash::make($password); // ✅ ahora sí hasheada
    $empleado->rol = 'empleado';

    // Marcar como activo y correo verificado
    $empleado->estado = 1;
    $empleado->correo_verificado_en = now();

    // Guardar en la base de datos
    $empleado->save();

    // Enviar correo con la contraseña en texto plano
    Mail::to($empleado->correo)->send(new EmpleadoPasswordMail($empleado, $password));

    return redirect()->route('admin.empleados.index')
        ->with('success', 'Empleado registrado y contraseña enviada al correo.');
}



    public function edit(string $id)
    {
        $empleado = User::findOrFail($id);
        return view('admin.empleados.edit', compact('empleado'));
    }

    public function update(Request $request, string $id)
    {
        $empleado = User::findOrFail($id);

        $request->validate([
            'nombre'           => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'correo'           => 'required|email|max:255|unique:users,correo,' . $empleado->id,
            'telefono'         => 'nullable|string|max:20',
            'fecha_nacimiento' => 'nullable|date',
            'contrasenia'       => 'nullable|string|min:6',
        ]);

        $empleado->nombre           = $request->nombre;
        $empleado->apellido_paterno = $request->apellido_paterno;
        $empleado->apellido_materno = $request->apellido_materno;
        $empleado->correo           = $request->correo;
        $empleado->telefono         = $request->telefono;
        $empleado->fecha_nacimiento = $request->fecha_nacimiento;

        if ($request->filled('contraseña')) {
            $empleado->contrasenia = bcrypt($request->contrasenia);
        }

        $empleado->save();

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado actualizado correctamente');
    }

    public function destroy(string $id)
    {
        $empleado = User::findOrFail($id);
        $empleado->delete();

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado eliminado correctamente');
    }
}
