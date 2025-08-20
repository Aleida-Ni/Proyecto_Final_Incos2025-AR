<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
class ProductoController extends Controller
{


public function index(Request $request)
{
    $categoriaNombre = $request->input('categoria');

    if ($categoriaNombre && $categoriaNombre !== 'todas') {
        $categoria = Categoria::where('nombre', $categoriaNombre)->first();

        if ($categoria) {
            $productos = Producto::where('categoria_id', $categoria->id)->get();
        } else {
            $productos = collect(); // vacío si no encuentra categoría
        }
    } else {
        $productos = Producto::all();
    }

    return view('cliente.productos.index', compact('productos'));
}


    

    public function create()
    {
        return view('admin.productos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($data);
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('admin.productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);
        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado.');
    }
    public function clienteIndex()
{
    $productos = Producto::all();
    return view('cliente.productos.index', compact('productos'));
}

}
