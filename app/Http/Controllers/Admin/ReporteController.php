<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Venta;
use Carbon\Carbon;


class ReporteController extends Controller
{
    public function __construct()
    {
        // Protege con los mismos middlewares que el resto del admin si quieres:
        $this->middleware(['auth', 'role:admin|empleado']);
    }

    /**
     * Reporte de reservas: filtro por fecha desde/hasta y estado.
     */
public function reservas(Request $request)
{
    $query = Reserva::query();

    // Filtro rápido
    if ($request->filled('periodo')) {
        switch ($request->periodo) {
            case '7':
                $query->where('fecha', '>=', Carbon::now()->subDays(7));
                break;
            case '15':
                $query->where('fecha', '>=', Carbon::now()->subDays(15));
                break;
            case '30':
                $query->where('fecha', '>=', Carbon::now()->subDays(30));
                break;
            case 'mes':
                $query->whereMonth('fecha', Carbon::now()->month)
                      ->whereYear('fecha', Carbon::now()->year);
                break;
            case 'mes_pasado':
                $query->whereMonth('fecha', Carbon::now()->subMonth()->month)
                      ->whereYear('fecha', Carbon::now()->subMonth()->year);
                break;
        }
    }

    // Filtro personalizado
    if ($request->filled('from')) {
        $query->where('fecha', '>=', $request->from);
    }
    if ($request->filled('to')) {
        $query->where('fecha', '<=', $request->to);
    }

    // Estado
    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }

    $reservas = $query->latest()->get();

    return view('admin.reportes.reservas', compact('reservas'))
        ->with([
            'from' => $request->from,
            'to' => $request->to,
            'estado' => $request->estado,
        ]);
}

    /**
     * Reporte de ventas: filtro por fecha desde/hasta (y opcionalmente por cliente).
     */
public function ventas(Request $request)
{
    $query = Venta::with(['cliente', 'detalles.producto']);

    // Filtro rápido
    if ($request->filled('periodo')) {
        switch ($request->periodo) {
            case '7':
                $query->where('creado_en', '>=', Carbon::now()->subDays(7));
                break;
            case '15':
                $query->where('creado_en', '>=', Carbon::now()->subDays(15));
                break;
            case '30':
                $query->where('creado_en', '>=', Carbon::now()->subDays(30));
                break;
            case 'mes':
                $query->whereMonth('creado_en', Carbon::now()->month)
                      ->whereYear('creado_en', Carbon::now()->year);
                break;
            case 'mes_pasado':
                $query->whereMonth('creado_en', Carbon::now()->subMonth()->month)
                      ->whereYear('creado_en', Carbon::now()->subMonth()->year);
                break;
        }
    }

    // Filtro personalizado
    if ($request->filled('from')) {
        $query->whereDate('creado_en', '>=', $request->from);
    }
    if ($request->filled('to')) {
        $query->whereDate('creado_en', '<=', $request->to);
    }

    // Cliente (ID o nombre)
    if ($request->filled('cliente')) {
        $cliente = $request->cliente;
        $query->whereHas('cliente', function ($q) use ($cliente) {
            $q->where('id', $cliente)
              ->orWhere('nombre', 'like', "%$cliente%");
        });
    }

    $ventas = $query->latest()->get();

    return view('admin.reportes.ventas', compact('ventas'));
}
}