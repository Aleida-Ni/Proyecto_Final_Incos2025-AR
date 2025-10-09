<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Venta;
use App\Models\Barbero;
use App\Models\User;
use App\Models\DetalleVenta;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|empleado']);
    }

    /**
     * Reporte de reservas con estadísticas
     */
// En ReporteController - método reservas
public function reservas(Request $request)
{
    $query = Reserva::with(['cliente', 'barbero', 'servicios', 'venta']);

    // Aplicar filtros de fecha
    if ($request->filled('from')) {
        $query->whereDate('fecha', '>=', $request->from);
    }

    if ($request->filled('to')) {
        $query->whereDate('fecha', '<=', $request->to);
    }

    // Filtro por periodo rápido
    if ($request->filled('periodo')) {
        $hoy = Carbon::today();
        
        switch ($request->periodo) {
            case 'hoy':
                $query->whereDate('fecha', $hoy);
                break;
            case '7':
                $query->whereDate('fecha', '>=', $hoy->copy()->subDays(7));
                break;
            case '15':
                $query->whereDate('fecha', '>=', $hoy->copy()->subDays(15));
                break;
            case '30':
                $query->whereDate('fecha', '>=', $hoy->copy()->subDays(30));
                break;
            case 'mes':
                $query->whereYear('fecha', $hoy->year)
                      ->whereMonth('fecha', $hoy->month);
                break;
            case 'mes_pasado':
                $query->whereYear('fecha', $hoy->copy()->subMonth()->year)
                      ->whereMonth('fecha', $hoy->copy()->subMonth()->month);
                break;
        }
    }

    // ✅ FILTRO POR ESTADO - ESTA ES LA PARTE IMPORTANTE
    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }

    // Filtro por barbero
    if ($request->filled('barbero_id')) {
        $query->where('barbero_id', $request->barbero_id);
    }

    $reservas = $query->orderBy('fecha', 'desc')
                     ->orderBy('hora', 'desc')
                     ->paginate(20);
    // Calcular estadísticas mejoradas
    $totalReservas = Reserva::when($request->filled('from'), function($q) use ($request) {
            // ... filtros de fecha
        })->count();

    $pendientes = Reserva::where('estado', 'pendiente')
        ->when($request->filled('from'), function($q) use ($request) {
            // ... filtros de fecha
        })->count();

    $realizadas = Reserva::where('estado', 'realizada')
        ->when($request->filled('from'), function($q) use ($request) {
            // ... filtros de fecha
        })->count();

    // Calcular ingresos
    $ingresoRealizado = Reserva::where('estado', 'realizada')
        ->with('venta')
        ->get()
        ->sum(function($reserva) {
            return $reserva->venta ? $reserva->venta->total : 0;
        });

    $ingresoPendiente = Reserva::where('estado', 'pendiente')
        ->with('servicios')
        ->get()
        ->sum(function($reserva) {
            return $reserva->servicios->sum('precio');
        });

    $estadisticas = [
        'total' => $totalReservas,
        'pendientes' => $pendientes,
        'realizadas' => $realizadas,
        'canceladas' => Reserva::where('estado', 'cancelada')->count(),
        'no_asistio' => Reserva::where('estado', 'no_asistio')->count(),
        'ingreso_total' => $ingresoRealizado,
        'ingreso_pendiente' => $ingresoPendiente,
        'ingreso_realizado' => $ingresoRealizado,
        'promedio_reserva' => $realizadas > 0 ? $ingresoRealizado / $realizadas : 0,
        'reservas_por_dia' => $totalReservas > 0 ? $totalReservas / 30 : 0, // Aproximado
        'tasa_asistencia' => $totalReservas > 0 ? round(($realizadas / $totalReservas) * 100, 1) : 0,
        'tasa_cancelacion' => $totalReservas > 0 ? round((Reserva::where('estado', 'cancelada')->count() / $totalReservas) * 100, 1) : 0,
        'tasa_no_asistencia' => $totalReservas > 0 ? round((Reserva::where('estado', 'no_asistio')->count() / $totalReservas) * 100, 1) : 0,
    ];

$barberos = Barbero::where('estado', 1)->get();
    return view('admin.reportes.reservas', compact('reservas', 'estadisticas', 'barberos'));
}

    /**
     * Reporte de ventas con métricas
     */
    public function ventas(Request $request)
    {
        $query = Venta::with(['cliente', 'detalles.producto', 'empleado']);

        // Aplicar filtros
        $this->aplicarFiltrosFecha($query, $request, 'creado_en');
        
        if ($request->filled('empleado_id')) {
            $query->where('empleado_id', $request->empleado_id);
        }

        if ($request->filled('metodo_pago')) {
            $query->where('metodo_pago', $request->metodo_pago);
        }

        // CAMBIO: Usar paginate en lugar de get
        $ventas = $query->latest()->paginate(20);
        
        // Calcular métricas (usamos get para las métricas)
        $ventasParaMetricas = $query->get();
        $metricas = [
            'total_ventas' => $ventasParaMetricas->count(),
            'ingreso_total' => $ventasParaMetricas->sum('total'),
            'venta_promedio' => $ventasParaMetricas->avg('total') ?? 0,
            'venta_maxima' => $ventasParaMetricas->max('total') ?? 0,
        ];

        $empleados = User::whereIn('rol', ['admin', 'empleado'])->get();

        return view('admin.reportes.ventas', compact('ventas', 'metricas', 'empleados'))
            ->with($request->only(['from', 'to', 'periodo', 'empleado_id', 'metodo_pago']));
    }

    /**
     * Reporte de productos más vendidos
     */
    public function productos(Request $request)
    {
        $query = DetalleVenta::join('ventas', 'detalles_venta.venta_id', '=', 'ventas.id')
            ->join('productos', 'detalles_venta.producto_id', '=', 'productos.id')
            ->select(
                'productos.id',
                'productos.nombre',
                'productos.precio',
                DB::raw('SUM(detalles_venta.cantidad) as total_vendido'),
                DB::raw('SUM(detalles_venta.subtotal) as ingreso_total')
            )
            ->groupBy('productos.id', 'productos.nombre', 'productos.precio');

        // Aplicar filtros de fecha
        if ($request->filled('from')) {
            $query->whereDate('ventas.creado_en', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('ventas.creado_en', '<=', $request->to);
        }

        // CAMBIO: Usar paginate en lugar de get
        $productos = $query->orderByDesc('total_vendido')->paginate(15);

        return view('admin.reportes.productos', compact('productos'))
            ->with($request->only(['from', 'to']));
    }

    /**
     * Dashboard de reportes
     */
    public function dashboard()
    {
        $hoy = Carbon::today();
        
        $metricas = [
            'ventas_hoy' => Venta::whereDate('creado_en', $hoy)->count(),
            'ingresos_hoy' => Venta::whereDate('creado_en', $hoy)->sum('total'),
            'reservas_hoy' => Reserva::whereDate('fecha', $hoy)->count(),
            'reservas_pendientes' => Reserva::where('estado', 'pendiente')->count(),
        ];

        // Ventas de los últimos 7 días para gráfico
        $ventasUltimaSemana = Venta::where('creado_en', '>=', $hoy->subDays(7))
            ->selectRaw('DATE(creado_en) as fecha, COUNT(*) as cantidad, SUM(total) as ingresos')
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        // Productos más vendidos del mes
        $productosPopulares = DetalleVenta::join('ventas', 'detalles_venta.venta_id', '=', 'ventas.id')
            ->join('productos', 'detalles_venta.producto_id', '=', 'productos.id')
            ->whereMonth('ventas.creado_en', Carbon::now()->month)
            ->select('productos.nombre', DB::raw('SUM(detalles_venta.cantidad) as total'))
            ->groupBy('productos.id', 'productos.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('admin.reportes.dashboard', compact('metricas', 'ventasUltimaSemana', 'productosPopulares'));
    }

    /**
     * Helper para aplicar filtros de fecha
     */
    private function aplicarFiltrosFecha($query, $request, $campoFecha)
    {
        if ($request->filled('periodo')) {
            switch ($request->periodo) {
                case 'hoy':
                    $query->whereDate($campoFecha, Carbon::today());
                    break;
                case '7':
                    $query->where($campoFecha, '>=', Carbon::now()->subDays(7));
                    break;
                case '15':
                    $query->where($campoFecha, '>=', Carbon::now()->subDays(15));
                    break;
                case '30':
                    $query->where($campoFecha, '>=', Carbon::now()->subDays(30));
                    break;
                case 'mes':
                    $query->whereMonth($campoFecha, Carbon::now()->month)
                          ->whereYear($campoFecha, Carbon::now()->year);
                    break;
                case 'mes_pasado':
                    $query->whereMonth($campoFecha, Carbon::now()->subMonth()->month)
                          ->whereYear($campoFecha, Carbon::now()->subMonth()->year);
                    break;
            }
        }

        if ($request->filled('from')) {
            $query->whereDate($campoFecha, '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate($campoFecha, '<=', $request->to);
        }
    }
}