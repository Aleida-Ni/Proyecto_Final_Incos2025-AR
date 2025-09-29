<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::all();

        $query = Producto::with('categoria');

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        $productos = $query->get();

        return view('admin.productos.index', [
            'productos' => $productos,
            'categorias' => $categorias,
        ]);
    }

    public function create()
    {
        $categorias = Categoria::all();

        if ($categorias->isEmpty()) {
            $defaults = [
                ['nombre' => 'CERAS Y GELES'],
                ['nombre' => 'CUIDADOS DE BARBA'],
                ['nombre' => 'CAPAS PERSONALIZADAS'],
            ];
            foreach ($defaults as $d) {
                Categoria::firstOrCreate(['nombre' => $d['nombre']]);
            }
            $categorias = Categoria::all();
        }

        return view('admin.productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048',
        ]);

        try {
            if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
                $data['imagen'] = $request->file('imagen')->store('productos', 'public');
            }

            Producto::create($data);

            return redirect()->route('admin.productos.index')->with('success', 'Producto creado exitosamente.');
        } catch (\Throwable $e) {
            Log::error('Error al crear producto: '.$e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Ocurrió un error al guardar el producto. Revisa los logs.']);
        }
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }
        $producto->delete();
        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado.');
    }
}
