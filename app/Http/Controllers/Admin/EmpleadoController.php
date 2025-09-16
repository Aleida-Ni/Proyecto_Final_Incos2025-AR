<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail; // 👈 Faltaba esto
use App\Mail\EmpleadoCreadoMail;

class EmpleadoController extends Controller
{
    /**
     * Mostrar la lista de empleados.
     */
    public function index()
    {
        $empleados = User::where('rol', 'empleado')->get();
        return view('admin.empleados.index', compact('empleados'));
    }

    /**
     * Mostrar el formulario de creación.
     */
    public function create()
    {
        return view('admin.empleados.create');
    }

    /**
     * Guardar un nuevo empleado.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'            => 'required|string|max:255',
            'apellido_paterno'  => 'required|string|max:255',
            'apellido_materno'  => 'required|string|max:255',
            'correo'            => 'required|string|email|max:255|unique:users,correo',
            'telefono'          => 'nullable|string|max:20',
            'fecha_nacimiento'  => 'nullable|date',
        ]);

        // 🔑 Generar contraseña aleatoria
        $contraseniaGenerada = Str::random(10);

        // Crear el empleado
        $empleado = User::create([
            'nombre'            => $request->nombre,
            'apellido_paterno'  => $request->apellido_paterno,
            'apellido_materno'  => $request->apellido_materno,
            'correo'            => $request->correo,
            'contrasenia'       => Hash::make($contraseniaGenerada),
            'telefono'          => $request->telefono,
            'fecha_nacimiento'  => $request->fecha_nacimiento,
            'rol'               => 'empleado',
            'estado'            => 1, // activo por defecto
        ]);

        // 📧 Enviar el correo con la contraseña generada
        Mail::to($empleado->correo)->send(new EmpleadoCreadoMail($empleado, $contraseniaGenerada));

        return redirect()->route('admin.empleados.index')
            ->with('success', 'Empleado registrado correctamente. La contraseña fue enviada por correo.');
    }

    /**
     * Mostrar el formulario de edición.
     */
    public function edit(string $id)
    {
        $empleado = User::findOrFail($id);
        return view('admin.empleados.edit', compact('empleado'));
    }

    /**
     * Actualizar un empleado.
     */
    public function update(Request $request, string $id)
    {
        $empleado = User::findOrFail($id);

        $request->validate([
            'nombre'            => 'required|string|max:255',
            'apellido_paterno'  => 'required|string|max:255',
            'apellido_materno'  => 'required|string|max:255',
            'correo'            => 'required|string|email|max:255|unique:users,correo,' . $empleado->id,
            'telefono'          => 'nullable|string|max:20',
            'fecha_nacimiento'  => 'nullable|date',
        ]);

        $empleado->update([
            'nombre'            => $request->nombre,
            'apellido_paterno'  => $request->apellido_paterno,
            'apellido_materno'  => $request->apellido_materno,
            'correo'            => $request->correo,
            'telefono'          => $request->telefono,
            'fecha_nacimiento'  => $request->fecha_nacimiento,
        ]);

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado actualizado correctamente');
    }

    /**
     * Eliminar un empleado.
     */
    public function destroy(string $id)
    {
        $empleado = User::findOrFail($id);
        $empleado->delete();

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado eliminado correctamente');
    }
}
