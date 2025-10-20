<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Support\Facades\Log;


class VentaController extends Controller
{
    // Lista de ventas
    public function index()
    {
        $ventas = Venta::with(['detalles.producto', 'empleado'])
            ->orderByDesc('creado_en')
            ->paginate(25);
        
        return view('admin.ventas.index', compact('ventas'));
    }

    // Formulario POS (crear venta)
    public function create()
    {
        $productos = Producto::with('categoria')
            ->orderBy('nombre')
            ->get();
        
        // Agrupar por categoría
        $productosPorCategoria = $productos->groupBy(function($producto) {
            return $producto->categoria->nombre ?? 'Sin categoría';
        });

        // Agregar opción "Todas" con todos los productos
        $productosPorCategoria = $productosPorCategoria->prepend($productos, 'Todas las categorías');

        return view('admin.ventas.create', compact('productosPorCategoria'));
    }


    // Guardar venta - CON REGISTRO DEL USUARIO AUTENTICADO
public function store(Request $request)
{
    DB::beginTransaction();
    
    try {
        $data = $request->all();
        $items = $data['items'] ?? [];

        if(empty($items)) {
            return response()->json(['error' => 'No hay productos en la venta'], 400);
        }

        // Generar código único para la venta
        $codigo = 'V-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        // Crear la venta
        $venta = Venta::create([
            'usuario_id' => $data['cliente_id'] ?? null,
            'empleado_id' => auth()->id(),
            'estado' => 'completada',
            'metodo_pago' => $data['metodo_pago'] ?? 'efectivo',
            'referencia_pago' => $data['referencia_pago'] ?? null,
            'fecha_pago' => now(),
            'codigo' => $codigo,
            'total' => 0,
            'creado_en' => now(),
        ]);

        $total = 0;
        $detalleItems = [];
        
        foreach($items as $item) {
            Log::info('Procesando item:', $item);
            
            $producto = Producto::find($item['producto_id']);
            
            if(!$producto) {
                throw new \Exception("Producto no encontrado: {$item['producto_id']}");
            }

            // Verificar stock
            if(isset($producto->stock) && $producto->stock < $item['cantidad']) {
                throw new \Exception("Stock insuficiente para: {$producto->nombre}");
            }

            $subtotal = $producto->precio * $item['cantidad'];
            $total += $subtotal;

            // CREAR DETALLE DE VENTA - ESTA ES LA PARTE IMPORTANTE
            $detalle = DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $producto->id,
                'cantidad' => $item['cantidad'],
                'precio' => $producto->precio,
                'subtotal' => $subtotal,
            ]);

            Log::info('Detalle creado:', $detalle->toArray());

            // Actualizar stock si existe
            if(isset($producto->stock)) {
                $producto->decrement('stock', $item['cantidad']);
            }

            $detalleItems[] = [
                'nombre' => $producto->nombre,
                'cantidad' => $item['cantidad'],
                'precio' => $producto->precio,
                'subtotal' => $subtotal,
            ];
        }

        // Actualizar total de la venta
        $venta->update(['total' => $total]);

        DB::commit();

        Log::info('Venta completada:', [
            'venta_id' => $venta->id,
            'total' => $total,
            'items_count' => count($detalleItems)
        ]);

        return response()->json([
            'success' => true,
            'venta_id' => $venta->id,
            'codigo' => $codigo,
            'total' => $total,
            'items' => $detalleItems,
            'message' => 'Venta registrada exitosamente',
            'redirect_url' => route('admin.ventas.show', $venta)
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error en store venta:', ['error' => $e->getMessage()]);
        return response()->json([
            'error' => 'Error al procesar la venta: ' . $e->getMessage()
        ], 500);
    }
}

    // Ver detalle de venta
    public function show(Venta $venta)
    {
        $venta->load(['detalles.producto', 'empleado']);
        return view('admin.ventas.show', compact('venta'));
    }

    // Anular venta
    public function destroy(Venta $venta)
    {
        DB::beginTransaction();
        
        try {
            // Solo permitir anular ventas recientes (menos de 24 horas)
            if($venta->creado_en->diffInHours(now()) > 24) {
                return redirect()->back()
                    ->with('error', 'Solo se pueden anular ventas de menos de 24 horas');
            }

            if($venta->estado === 'anulada') {
                return redirect()->back()
                    ->with('error', 'Esta venta ya está anulada');
            }

            // Restaurar stock de productos si existe la columna
            foreach($venta->detalles as $detalle) {
                $producto = $detalle->producto;
                if(isset($producto->stock)) {
                    $producto->increment('stock', $detalle->cantidad);
                }
            }

            // Actualizar estado de la venta
            $venta->update([
                'estado' => 'anulada',
                'actualizado_en' => now()
            ]);

            DB::commit();

            return redirect()->route('admin.ventas.index')
                ->with('success', 'Venta anulada exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al anular la venta: ' . $e->getMessage());
        }
    }
}