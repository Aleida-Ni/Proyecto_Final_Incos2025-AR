<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class VentaController extends Controller
{
    // Mostrar carrito (vista normal)
    public function index()
    {
        $carrito = session('carrito', []);
        return view('cliente.ventas.index', compact('carrito'));
    }

    // Agregar producto al carrito (AJAX)
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

    // Vaciar carrito
    public function vaciar()
    {
        session()->forget('carrito');
        return response()->json(['status' => 'ok']);
    }
// Devuelve el partial del carrito
// Devuelve el partial del carrito
public function modalCarrito()
{
    $carrito = session('carrito', []);
    return view('cliente.ventas.carrito_modal', compact('carrito'));
}

public function verCarrito()
{
    $carrito = session('carrito', []);
    return view('cliente.partials.carrito_modal', compact('carrito'));
}

    // Confirmar compra (devuelve modal con QR)
    public function confirmarCompra(Request $request)
    {
        $user = auth()->user();
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return response()->json(['error' => 'Carrito vacío'], 400);
        }

        DB::beginTransaction();
        try {
            $venta = Venta::create([
                'cliente_id' => $user->id,
                'empleado_id' => null,
                'codigo' => 'PED-' . strtoupper(uniqid()),
                'total' => 0,
            ]);

            $total = 0;
            foreach ($carrito as $id => $item) {
                $subtotal = $item['precio'] * $item['cantidad'];
                $total += $subtotal;

                $venta->detalles()->create([
                    'producto_id' => $id,
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio'],
                    'subtotal' => $subtotal,
                ]);

                $producto = Producto::find($id);
                $producto->stock -= $item['cantidad'];
                $producto->save();
            }

            $venta->update(['total' => $total]);

            session()->forget('carrito');

            // Generar QR en SVG
            $qrSvg = QrCode::format('svg')->size(200)->generate($venta->codigo);

            return view('cliente.ventas.modal_confirmar', compact('venta', 'qrSvg'));

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
// Aumentar cantidad
public function aumentar(Request $request, $id)
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

// Disminuir cantidad
public function disminuir(Request $request, $id)
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

}
