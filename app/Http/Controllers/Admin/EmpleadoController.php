<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
        $request->validate([
            'nombre'           => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'correo'           => 'required|email|max:255|unique:users,correo',
            'telefono'         => 'nullable|string|max:20',
            'fecha_nacimiento' => 'nullable|date',
            'contraseña'       => 'required|string|min:6',
        ]);

        User::create([
            'nombre'           => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'correo'           => $request->correo,
            'contraseña'       => bcrypt($request->contraseña),
            'telefono'         => $request->telefono,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'rol'              => 'empleado',
            'estado'           => true,
        ]);

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado registrado correctamente');
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
            'contraseña'       => 'nullable|string|min:6',
        ]);

        $empleado->nombre           = $request->nombre;
        $empleado->apellido_paterno = $request->apellido_paterno;
        $empleado->apellido_materno = $request->apellido_materno;
        $empleado->correo           = $request->correo;
        $empleado->telefono         = $request->telefono;
        $empleado->fecha_nacimiento = $request->fecha_nacimiento;

        if ($request->filled('contraseña')) {
            $empleado->contraseña = bcrypt($request->contraseña);
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
