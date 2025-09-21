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
        $from = $request->input('from');
        $to   = $request->input('to');
        $estado = $request->input('estado');

        $query = Reserva::with(['cliente', 'barbero']);

        if ($from) {
            $query->where('fecha', '>=', $from);
        }
        if ($to) {
            $query->where('fecha', '<=', $to);
        }
        if ($estado) {
            $query->where('estado', $estado);
        }

        // Ordenamos por fecha/hora
        $reservas = $query->orderBy('fecha', 'desc')->orderBy('hora', 'asc')->get();

        return view('admin.reportes.reservas', compact('reservas','from','to','estado'));
    }

    /**
     * Reporte de ventas: filtro por fecha desde/hasta (y opcionalmente por cliente).
     */
    public function ventas(Request $request)
    {
        $from = $request->input('from');
        $to   = $request->input('to');
        $cliente = $request->input('cliente');

        $query = Venta::with(['cliente', 'detalles.producto']); // adapta relaciones si tus modelos son distintos

        if ($from) {
            $query->where('creado_en', '>=', $from);
        }
        if ($to) {
            $query->where('creado_en', '<=', $to);
        }
        if ($cliente) {
            $query->where('cliente_id', $cliente);
        }

        $ventas = $query->orderBy('creado_en', 'desc')->get();

        return view('admin.reportes.ventas', compact('ventas','from','to','cliente'));
    }
}