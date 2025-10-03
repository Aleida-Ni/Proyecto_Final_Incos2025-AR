<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\User;

class VentaController extends Controller
{
    // Lista de ventas
public function index()
{
    // Traemos todas las ventas ordenadas por fecha
    $ventas = Venta::orderByDesc('creado_en')->paginate(25); // tu columna en español
    
    return view('admin.ventas.index', compact('ventas'));
}


    // Formulario POS (crear venta)
public function create()
{
    $productos = Producto::with('categoria')->orderBy('nombre')->get();
    $productosPorCategoria = $productos->groupBy(fn($p) => $p->categoria->nombre ?? 'Sin categoría');

    $clientes = User::where('rol', 'cliente')->orderBy('nombre')->get();

    return view('admin.ventas.create', compact('productosPorCategoria', 'clientes'));
}


    // Guardar venta
public function store(Request $request)
{
    $data = $request->all(); // viene JSON
    $items = $data['items'] ?? [];

    if(empty($items)) {
        return response()->json(['error'=>'No hay productos'],400);
    }

    $venta = Venta::create([
        'cliente_id' => $data['cliente_id'] ?? null,
        'empleado_id' => auth()->id(),
        'total' => 0, // se calcula luego
        'creado_en' => now(),
    ]);

    $total = 0;
    $detalleItems = [];
    foreach($items as $id => $cantidad){
        $producto = Producto::find($id);
        if(!$producto) continue;

        $subtotal = $producto->precio * $cantidad;
        $total += $subtotal;

        $detalle = DetalleVenta::create([
            'venta_id' => $venta->id,
            'producto_id' => $producto->id,
            'cantidad' => $cantidad,
            'precio' => $producto->precio,
        ]);

        $detalleItems[] = [
            'nombre' => $producto->nombre,
            'cantidad' => $cantidad,
            'precio' => $producto->precio,
        ];
    }

    $venta->total = $total;
    $venta->save();

    return response()->json([
        'success' => true,
        'venta_id' => $venta->id,
        'total' => $total,
        'items' => $detalleItems,
    ]);
}

    // Ver detalle de venta
public function show(Venta $venta)
{
    $venta->load('detalles.producto');
    return view('admin.ventas.show', compact('venta'));
}

}
