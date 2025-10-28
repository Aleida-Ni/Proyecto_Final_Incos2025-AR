<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicio;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::orderBy('nombre')->get();
        return view('admin.servicios.index', compact('servicios'));
    }

    public function create()
    {
        return view('admin.servicios.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:191',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'duracion_minutos' => 'required|integer|min:1',
            // recibimos '0' o '1' desde el formulario
            'activo' => 'sometimes|in:0,1'
        ]);

        // Asegurar que guardamos 0/1
        $data['activo'] = $request->input('activo', '0') === '1' ? 1 : 0;

        Servicio::create($data);

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio creado correctamente.');
    }

    public function edit(Servicio $servicio)
    {
        return view('admin.servicios.edit', compact('servicio'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:191',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'duracion_minutos' => 'required|integer|min:1',
            'activo' => 'sometimes|in:0,1'
        ]);

        $data['activo'] = $request->input('activo', '0') === '1' ? 1 : 0;

        $servicio->update($data);

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(Servicio $servicio)
    {
        // Si el servicio está referenciado en reservas o detalle, evitar borrado destructivo
        $pivotCount = $servicio->serviciosReserva()->count();
        $reservasCount = $servicio->reservas()->count();

        if ($pivotCount > 0 || $reservasCount > 0) {
            $total = $pivotCount + $reservasCount;
            return redirect()->route('admin.servicios.index')
                ->with('error', "No se puede eliminar este servicio porque está asociado a $total reservas/entradas históricas. Desactívalo en su lugar.");
        }

        $servicio->delete();
        return redirect()->route('admin.servicios.index')->with('success', 'Servicio eliminado correctamente.');
    }
}
