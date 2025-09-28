<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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
        return redirect()->route('cliente.ventas.index')
            ->with('error', 'El carrito está vacío.');
    }

    $total = 0;

    DB::beginTransaction();
    try {
        // Crear la venta
        $venta = Venta::create([
            'cliente_id' => $user->id,
            'empleado_id' => null,
            'codigo' => 'PED-' . strtoupper(uniqid()),
            'total' => 0,
        ]);

        foreach ($carrito as $id => $item) {
            $producto = Producto::findOrFail($id);

            // Verificar stock
            if ($producto->stock < $item['cantidad']) {
                throw new \Exception("No hay suficiente stock de {$producto->nombre}");
            }

            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;

            // Crear detalle
            $venta->detalles()->create([
                'producto_id' => $id,
                'cantidad' => $item['cantidad'],
                'precio' => $item['precio'],
                'subtotal' => $subtotal,
            ]);

            // Descontar stock
            $producto->stock -= $item['cantidad'];
            $producto->save();
        }

        // Actualizar total
        $venta->update(['total' => $total]);

        DB::commit();

        session()->forget('carrito');

        return view('cliente.ventas.confirmar', compact('venta'));
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('cliente.ventas.index')
            ->with('error', $e->getMessage());
    }
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