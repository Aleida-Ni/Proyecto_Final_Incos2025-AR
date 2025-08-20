<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // 👈 Importamos el modelo User

class EmpleadoController extends Controller
{
    /**
     * Mostrar la lista de empleados
     */
public function index()
{
    $empleados = User::where('rol', 'empleado')->get(); // 👈 usa 'rol'
    return view('admin.empleados.index', compact('empleados'));
}


    /**
     * Mostrar el formulario de creación
     */
    public function create()
    {
        return view('admin.empleados.create');
    }

    /**
     * Guardar un nuevo empleado
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => bcrypt($request->password),
            'telefono'        => $request->telefono,
            'fecha_nacimiento'=> $request->fecha_nacimiento,
            'role'            => 'empleado',
        ]);

        return redirect()->route('empleados.index')->with('success', 'Empleado registrado correctamente');
    }

    /**
     * Mostrar la información de un empleado (opcional)
     */
    public function show(string $id)
    {
        $empleado = User::findOrFail($id);
        return view('admin.empleados.show', compact('empleado'));
    }

    /**
     * Mostrar el formulario de edición
     */
    public function edit(string $id)
    {
        $empleado = User::findOrFail($id);
        return view('admin.empleados.edit', compact('empleado'));
    }

    /**
     * Actualizar un empleado
     */
    public function update(Request $request, string $id)
    {
        $empleado = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $empleado->id,
            'password' => 'nullable|string|min:6',
        ]);

        $empleado->name = $request->name;
        $empleado->email = $request->email;
        $empleado->telefono = $request->telefono;
        $empleado->fecha_nacimiento = $request->fecha_nacimiento;

        if ($request->filled('password')) {
            $empleado->password = bcrypt($request->password);
        }

        $empleado->save();

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente');
    }

    /**
     * Eliminar un empleado
     */
    public function destroy(string $id)
    {
        $empleado = User::findOrFail($id);
        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente');
    }
}
