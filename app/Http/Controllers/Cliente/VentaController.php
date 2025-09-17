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
    } else {
        $carrito[$id] = [
            'nombre' => $producto->nombre,
            'precio' => $producto->precio,
            'cantidad' => 1,
        ];
    }

    session()->put('carrito', $carrito);

    return response()->json([
        'cantidad_total' => array_sum(array_column($carrito, 'cantidad'))
    ]);
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
 * Aumentar cantidad de un producto en el carrito
 */
public function aumentar($id)
{
    $carrito = session()->get('carrito', []);

    if (isset($carrito[$id])) {
        $carrito[$id]['cantidad']++;
        session()->put('carrito', $carrito);
    }

    return response()->json([
        'status' => 'ok',
        'cantidad_total' => array_sum(array_column($carrito, 'cantidad'))
    ]);
}

/**
 * Disminuir cantidad de un producto en el carrito
 */
public function disminuir($id)
{
    $carrito = session()->get('carrito', []);

    if (isset($carrito[$id])) {
        $carrito[$id]['cantidad']--;
        if ($carrito[$id]['cantidad'] <= 0) {
            unset($carrito[$id]);
        }
        session()->put('carrito', $carrito);
    }

    return response()->json([
        'status' => 'ok',
        'cantidad_total' => array_sum(array_column($carrito, 'cantidad'))
    ]);
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
public function modalCarrito() {
    $carrito = session('carrito', []);
    return view('cliente.partials.carrito_modal', compact('carrito'));
}

public function vaciar() {

    session()->forget('carrito');
    return response()->json(['status' => 'ok']);
}

}