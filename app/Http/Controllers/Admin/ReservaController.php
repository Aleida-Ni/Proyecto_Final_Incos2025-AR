<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barbero;
use App\Models\Reserva;
use App\Models\Servicio;
use App\Models\ServicioReserva;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservaController extends Controller
{
    /** Listar todas las reservas */
    public function index(Request $request)
{
    // Obtener todas las reservas SIN paginación
    $reservas = Reserva::with(['cliente', 'barbero', 'servicios', 'venta'])
        ->orderBy('fecha', 'desc')
        ->orderBy('hora', 'desc')
        ->get(); // Cambia paginate() por get()

    // El resto de tu código para estadísticas se mantiene igual
    $estadisticas = [
        'total' => Reserva::count(),
        'pendientes' => Reserva::where('estado', 'pendiente')->count(),
        'hoy' => Reserva::whereDate('fecha', today())->count(),
        'esta_semana' => Reserva::whereBetween('fecha', [now()->startOfWeek(), now()->endOfWeek()])->count(),
    ];

    return view('admin.reservas.index', compact('reservas', 'estadisticas'));
}
    /** Mostrar formulario para completar reserva */
    public function showCompletar(Reserva $reserva)
    {
        $servicios = Servicio::where('activo', true)->get();
        return view('admin.reservas.marcar-realizada', compact('reserva', 'servicios'));
    }

    /** Completar reserva y generar venta */
    public function completar(Request $request, Reserva $reserva)
{
    $request->validate([
        'servicios' => 'required|array|min:1',
        'servicios.*' => 'exists:servicios,id',
        'metodo_pago' => 'required|in:efectivo,qr',
        'monto_total' => 'required|numeric|min:0',
        'observaciones' => 'nullable|string|max:500'
    ]);

    DB::beginTransaction();

    try {
        $reserva->update([
            
            'estado' => 'realizada',
            'metodo_pago' => $request->metodo_pago,
            'pago_realizado' => 1,
            'actualizado_en' => now()
        ]);

        $venta = Venta::create([
            'reserva_id' => $reserva->id,
            'usuario_id' => $reserva->usuario_id,
            'empleado_id' => auth()->id(),
            'codigo' => 'VENTA-' . strtoupper(uniqid()),
            'total' => $request->monto_total,
            'metodo_pago' => $request->metodo_pago,
            'estado' => 'completada',
            'fecha_pago' => now(),
            'observaciones' => $request->observaciones,
            'creado_en' => now(),
            'actualizado_en' => now()
        ]);

        $serviciosSeleccionados = Servicio::whereIn('id', $request->servicios)->get();
        
        foreach ($serviciosSeleccionados as $servicio) {
            ServicioReserva::create([
                'reserva_id' => $reserva->id,
                'servicio_id' => $servicio->id,
                'precio' => $servicio->precio,
                'creado_en' => now(),
                'actualizado_en' => now()
            ]);
        }

        DB::commit();

        return redirect()->route('admin.reservas.show', $reserva)
            ->with('success', 'Reserva completada exitosamente! Total: $' . number_format($request->monto_total, 2));

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error al completar reserva: ' . $e->getMessage());
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
}

    public function marcar($id, $estado)
    {
        $reserva = Reserva::findOrFail($id);

        if (!in_array($estado, ['realizada', 'no_asistio', 'cancelada'])) {
            return back()->with('error', 'Estado no válido.');
        }

        $reserva->update([
            'estado' => $estado,
            'actualizado_en' => now()
        ]);

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva actualizada.');
    }

    /** Crear */
    public function create()
    {
        $barberos = Barbero::where('activo', true)->get();
        return view('admin.reservas.create', compact('barberos'));
    }

    /** Guardar */
// En el método store del controlador Admin
public function store(Request $request)
{
    $request->validate([
        'servicios' => 'required|array',
        'servicios.*' => 'exists:servicios,id',
        'metodo_pago' => 'required|in:efectivo,qr',
        'monto_total' => 'required|numeric|min:0',
        'observaciones' => 'nullable|string'
    ]);

    try {
        DB::beginTransaction();

        // ✅ CORREGIDO: Usar usuario_id en lugar de cliente_id
        $reserva = Reserva::create([
            'usuario_id' => auth()->id(),  // ← CAMBIADO
            'barbero_id' => $request->barbero_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => 'realizada',
            'metodo_pago' => $request->metodo_pago,
            'observaciones' => $request->observaciones,
            'creado_en' => now(),
            'actualizado_en' => now()
        ]);

        $venta = Venta::create([
            'reserva_id' => $reserva->id,
            'usuario_id' => $reserva->usuario_id,  
            'codigo' => 'V-' . date('Ymd') . '-' . strtoupper(uniqid()),
            'total' => $request->monto_total,
            'metodo_pago' => $request->metodo_pago,
            'estado' => 'completada'
        ]);

        foreach ($request->servicios as $servicioId) {
            $servicio = Servicio::find($servicioId);
            $venta->servicios()->attach($servicioId, [
                'precio' => $servicio->precio
            ]);
        }

        DB::commit();

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva completada exitosamente');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error al completar la reserva: ' . $e->getMessage());
    }
}
    /** Mostrar */
    public function show(Reserva $reserva)
    {
        $reserva->load(['cliente', 'barbero', 'servicios.servicio', 'venta']);
        
        return view('admin.reservas.show', compact('reserva'));
    }

    /**
     * Devuelve JSON con los datos de la reserva (para uso en modales/tickets via JS)
     */
    public function json(Reserva $reserva)
    {
        $reserva->load(['cliente', 'barbero', 'servicios.servicio', 'venta']);

        // Mapear servicios para exponer nombre y precio (usando pivot si existe)
        $servicios = $reserva->servicios->map(function ($s) {
            return [
                'id' => $s->id,
                'nombre' => optional($s->servicio)->nombre ?? $s->nombre ?? null,
                'precio' => isset($s->precio) ? (float) $s->precio : (float) ($s->pivot->precio ?? 0),
                'pivot' => [
                    'precio' => isset($s->precio) ? (float) $s->precio : (float) ($s->pivot->precio ?? 0),
                ]
            ];
        })->values();

        $fmtDate = function ($val) {
            if (! $val) return null;
            try {
                if ($val instanceof \Carbon\Carbon) return $val->toDateString();
                return Carbon::parse($val)->toDateString();
            } catch (\Throwable $e) {
                return (string) $val;
            }
        };

        $fmtDateTime = function ($val) {
            if (! $val) return null;
            try {
                if ($val instanceof \Carbon\Carbon) return $val->toDateTimeString();
                return Carbon::parse($val)->toDateTimeString();
            } catch (\Throwable $e) {
                return (string) $val;
            }
        };

        return response()->json([
            'id' => $reserva->id,
            'cliente' => [ 'nombre' => optional($reserva->cliente)->nombre ],
            'barbero' => [ 'nombre' => optional($reserva->barbero)->nombre ],
            'fecha' => $fmtDate($reserva->fecha),
            'hora' => $reserva->hora,
            'estado' => $reserva->estado,
            'servicios' => $servicios,
            'venta' => $reserva->venta ? [ 'total' => (float) $reserva->venta->total, 'metodo_pago' => $reserva->venta->metodo_pago ] : null,
            'metodo_pago' => $reserva->metodo_pago,
            'observaciones' => $reserva->observaciones,
            'creado_en' => $fmtDateTime($reserva->creado_en),
            'actualizado_en' => $fmtDateTime($reserva->actualizado_en),
        ]);
    }

    /** Editar */
    public function edit(Reserva $reserva)
    {
        $barberos = Barbero::where('activo', true)->get();
        return view('admin.reservas.edit', compact('reserva', 'barberos'));
    }

    /** Actualizar */
    public function update(Request $request, Reserva $reserva)
    {
        $request->validate([
            'barbero_id' => 'required|exists:barberos,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'estado' => 'required|in:pendiente,realizada,cancelada,no_asistio'
        ]);

        $yaReservada = Reserva::where('barbero_id', $request->barbero_id)
            ->where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('id', '!=', $reserva->id)
            ->exists();

        if ($yaReservada) {
            return back()->withErrors(['hora' => 'Esa hora ya está ocupada'])->withInput();
        }

        $reserva->update([
            'barbero_id' => $request->barbero_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => $request->estado,
            'actualizado_en' => now()
        ]);

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva actualizada.');
    }

    /** Eliminar */
    public function destroy(Reserva $reserva)
    {
        $reserva->delete();
        return redirect()->route('admin.reservas.index')->with('success', 'Reserva eliminada.');
    }

    /** Horas disponibles */
    public function getHorasDisponibles($barberoId, $fecha)
    {
        $horasOcupadas = Reserva::where('barbero_id', $barberoId)
            ->where('fecha', $fecha)
            ->where('estado', '!=', 'cancelada')
            ->pluck('hora')->toArray();

        $horasDisponibles = [];
        $inicio = Carbon::createFromTime(9, 30);
        $fin = Carbon::createFromTime(19, 30);
        $intervalo = 60;

        while ($inicio->lte($fin)) {
            $hora = $inicio->format('H:i');
            $horasDisponibles[$hora] = !in_array($hora, $horasOcupadas);
            $inicio->addMinutes($intervalo);
        }

        return response()->json($horasDisponibles);
    }
}