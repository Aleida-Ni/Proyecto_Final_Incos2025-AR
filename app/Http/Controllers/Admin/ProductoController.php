<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser negativo.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg.',
            'imagen.max' => 'La imagen no debe pesar más de 2MB.',
        ]);

        try {
            DB::beginTransaction();
            
            $data = $request->only(['nombre', 'precio', 'stock', 'categoria_id']);
            
            if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
                $data['imagen'] = $request->file('imagen')->store('productos', 'public');
            }

            $producto = Producto::create($data);
            
            DB::commit();

            return redirect()
                ->route('admin.productos.index')
                ->with('success', "¡Producto '{$producto->nombre}' creado exitosamente!");
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al crear producto: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // En desarrollo, mostrar el error real
            if (config('app.debug')) {
                return back()
                    ->withInput()
                    ->withErrors(['error' => 'Error: ' . $e->getMessage()]);
            }
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Hubo un error al guardar el producto. Por favor, inténtalo de nuevo.']);
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
