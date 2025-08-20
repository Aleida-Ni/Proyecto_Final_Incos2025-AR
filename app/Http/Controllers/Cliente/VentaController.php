<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Mostrar carrito (desde sesión)
     */
    public function index()
    {
        $carrito = session('carrito', []); // usamos 'carrito' como sesión
        return view('cliente.ventas.index', compact('carrito'));
    }

    /**
     * Agregar producto al carrito
     */
    public function agregar(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad']++;
            $carrito[$id]['subtotal'] = $carrito[$id]['cantidad'] * $producto->precio;
        } else {
            $carrito[$id] = [
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
                'subtotal' => $producto->precio,
            ];
        }

        session()->put('carrito', $carrito);

        return redirect()->back()->with('success', 'Producto agregado al carrito.');
    }

    /**
     * Eliminar producto del carrito
     */
    public function eliminar(Request $request, $productoId)
    {
        $carrito = $request->session()->get('carrito', []);
        if (isset($carrito[$productoId])) {
            unset($carrito[$productoId]);
            $request->session()->put('carrito', $carrito);
        }

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    /**
     * Confirmar compra
     */
public function confirmarCompra(Request $request)
{
    $user = auth()->user();
    $carrito = session('carrito', []);

    if (empty($carrito)) {
        return redirect()->route('cliente.ventas.index')->with('error', 'El carrito está vacío.');
    }

    $total = 0;

    // Crear la venta
    $venta = Venta::create([
        'cliente_id' => $user->id,
        'empleado_id' => null, // puede ser null porque ya lo hicimos nullable
        'codigo' => 'PED-' . strtoupper(uniqid()),
        'total' => 0,
    ]);

    // Agregar productos a detalles_venta
    foreach ($carrito as $id => $item) {
        $subtotal = $item['precio'] * $item['cantidad'];
        $total += $subtotal;

        $venta->detalles()->create([
            'producto_id' => $id,
            'cantidad' => $item['cantidad'],
            'precio' => $item['precio'], // precio unitario
            'subtotal' => $subtotal, // puedes agregar esta columna en detalles_venta
        ]);
    }

    $venta->update(['total' => $total]);

    session()->forget('carrito');

    return view('cliente.ventas.confirmar', compact('venta'));
}


    /**
     * Página de detalle de venta (opcional)
     */
    public function exito($ventaId)
    {
        $venta = Venta::with('detalles.producto')->findOrFail($ventaId);
        return view('cliente.ventas.confirmar', compact('venta'));
    }
}
