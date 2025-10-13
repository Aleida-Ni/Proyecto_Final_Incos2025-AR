<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use App\Models\Reserva;
use App\Models\Producto;
use App\Models\Usuario;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hoy = Carbon::today();
        
        $metricas = [
            'ventas_hoy' => Venta::whereDate('creado_en', $hoy)->count(),
            'ingresos_hoy' => Venta::whereDate('creado_en', $hoy)->sum('total'),
            'reservas_hoy' => Reserva::whereDate('fecha', $hoy)->count(),
            'reservas_pendientes' => Reserva::where('estado', 'pendiente')->count(),
            'total_productos' => Producto::count(),
            'total_clientes' => Usuario::where('rol', 'cliente')->count(),
        ];

        // Ventas de la última semana para gráfico
        $ventasUltimaSemana = Venta::where('creado_en', '>=', $hoy->subDays(7))
            ->selectRaw('DATE(creado_en) as fecha, COUNT(*) as cantidad, SUM(total) as ingresos')
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        // Reservas de hoy
        $reservasHoy = Reserva::with(['cliente', 'barbero'])
            ->whereDate('fecha', $hoy)
            ->orderBy('hora')
            ->get();

        return view('admin.dashboard', compact('metricas', 'ventasUltimaSemana', 'reservasHoy'));
    }
}