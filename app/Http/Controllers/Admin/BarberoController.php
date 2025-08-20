<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barbero;
use Illuminate\Support\Facades\Storage;

class BarberoController extends Controller
{
    public function index()
    {
        $barberos = Barbero::all();
        return view('admin.barberos.index', compact('barberos'));
    }

    public function create()
    {
        return view('admin.barberos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'correo' => 'required|email|unique:barberos,correo',
            'telefono' => 'nullable|string|max:20',
            'cargo' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|max:2048',
            'estado' => 'nullable|boolean',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('barberos', 'public');
        }

        Barbero::create($data);

        return redirect()->route('admin.barberos.index')->with('success', 'Barbero creado correctamente.');
    }

    public function edit(Barbero $barbero)
    {
        return view('admin.barberos.edit', compact('barbero'));
    }

    public function update(Request $request, Barbero $barbero)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'correo' => 'nullable|email|max:255|unique:barberos,correo,' . $barbero->id,
            'telefono' => 'nullable|string|max:20',
            'cargo' => 'required|string|max:255',
            'imagen' => 'nullable|image|max:2048',
            'estado' => 'nullable|boolean',
        ]);

        if ($request->hasFile('imagen')) {
            if ($barbero->imagen) {
                Storage::delete('public/' . $barbero->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('barberos', 'public');
        }

        $barbero->update($data);

        return redirect()->route('admin.barberos.index')->with('success', 'Barbero actualizado exitosamente.');
    }

    public function destroy(Barbero $barbero)
    {
        if ($barbero->imagen) {
            Storage::delete('public/' . $barbero->imagen);
        }
        $barbero->delete();
        return redirect()->route('admin.barberos.index')->with('success', 'Barbero eliminado.');
    }
}
