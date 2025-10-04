<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barbero;
use App\Models\Reserva;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    /**
     * Listar todas las reservas
     */
// En tu ReservaController - método index
public function index(Request $request)
{
    $query = Reserva::with(['cliente', 'barbero']);
    
    // Aplicar filtros
    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }
    
    if ($request->filled('fecha')) {
        $hoy = Carbon::today();
        switch ($request->fecha) {
            case 'hoy':
                $query->whereDate('fecha', $hoy);
                break;
            case 'futuro':
                $query->whereDate('fecha', '>=', $hoy);
                break;
            case 'pasado':
                $query->whereDate('fecha', '<', $hoy);
                break;
        }
    }
    
    $reservas = $query->orderBy('fecha')->orderBy('hora')->paginate(20);
    
    // Calcular estadísticas
    $estadisticas = [
        'total' => Reserva::count(),
        'pendientes' => Reserva::where('estado', 'pendiente')->count(),
        'hoy' => Reserva::whereDate('fecha', Carbon::today())->count(),
        'esta_semana' => Reserva::whereBetween('fecha', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count(),
    ];
    
    return view('admin.reservas.index', compact('reservas', 'estadisticas'));
}


public function marcar($id, $estado)
{
    $reserva = Reserva::findOrFail($id);

    if (!in_array($estado, ['realizada', 'no_asistio'])) {
        return redirect()->back()->with('error', 'Estado no válido.');
    }

    $reserva->estado = $estado;
    $reserva->save();

    return redirect()->route('admin.reservas.index')
        ->with('success', 'Reserva actualizada correctamente.');
}

    /**
     * Crear reserva para un barbero
     */
    public function create($barberoId, Request $request)
    {
        $barbero = Barbero::findOrFail($barberoId);
        $fecha = $request->get('fecha', date('Y-m-d'));

        $inicio = Carbon::createFromTime(9, 30);
        $fin = Carbon::createFromTime(19, 30);
        $intervalo = 60;

        $horas = [];

        while ($inicio->lte($fin)) {
            $horas[$inicio->format('H:i')] = true;
            $inicio->addMinutes($intervalo);
        }

        $ocupadas = Reserva::where('barbero_id', $barberoId)
            ->where('fecha', $fecha)
            ->pluck('hora')
            ->toArray();

        foreach ($ocupadas as $h) {
            if (isset($horas[$h])) {
                $horas[$h] = false;
            }
        }

        $horasDisponibles = $horas;

        return view('cliente.reservas.create', compact('barbero', 'fecha', 'horasDisponibles'));
    }

    /**
     * Guardar una nueva reserva
     */
    public function store(Request $r)
    {
        $r->validate([
            'barbero_id' => 'required|exists:barberos,id',
            'fecha' => 'required|date',
            'hora' => 'required',
        ]);

        $ya = Reserva::where('barbero_id', $r->barbero_id)
            ->where('fecha', $r->fecha)
            ->where('hora', $r->hora)
            ->exists();

        if ($ya) {
            return back()
                ->withErrors(['hora' => 'Hora ya reservada.'])
                ->withInput();
        }

        Reserva::create([
            'barbero_id' => $r->barbero_id,
            'usuario_id' => auth()->id(),
            'fecha' => $r->fecha,
            'hora' => $r->hora,
            'estado' => 'pendiente',
        ]);

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva creada con éxito');
    }
    /**
     * Marcar reserva como cancelada
     */
    public function marcarCancelada(Reserva $reserva)
    {
        $reserva->update(['estado' => 'cancelada']);

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva cancelada.');
    }
     public function showMarcarRealizada(Reserva $reserva)
    {
        $servicios = Servicio::where('activo', true)->get();
        return view('admin.reservas.marcar-realizada', compact('reserva', 'servicios'));
    }

    /**
     * Procesar reserva realizada con servicios
     */
    public function marcarRealizada(Request $request, Reserva $reserva)
    {
        $request->validate([
            'servicios' => 'required|array|min:1',
            'servicios.*' => 'exists:servicios,id',
            'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia',
            'referencia_pago' => 'nullable|string|max:50'
        ]);

        // Iniciar transacción
        \DB::beginTransaction();

        try {
            // Actualizar estado de la reserva
            $reserva->update([
                'estado' => 'realizada',
                'actualizado_en' => now()
            ]);

            // Adjuntar servicios con sus precios actuales
            $serviciosConPrecios = [];
            foreach ($request->servicios as $servicioId) {
                $servicio = Servicio::find($servicioId);
                $serviciosConPrecios[$servicioId] = ['precio' => $servicio->precio];
            }

            $reserva->servicios()->attach($serviciosConPrecios);

            // Crear venta automáticamente
            $total = $reserva->total_servicios;
            $codigo = 'V-' . date('Ymd') . '-' . strtoupper(\Str::random(6));

            $venta = \App\Models\Venta::create([
                'cliente_id' => $reserva->usuario_id, // El cliente que hizo la reserva
                'empleado_id' => auth()->id(),
                'estado' => 'completada',
                'metodo_pago' => $request->metodo_pago,
                'referencia_pago' => $request->referencia_pago,
                'fecha_pago' => now(),
                'codigo' => $codigo,
                'total' => $total,
                'creado_en' => now(),
            ]);

            // Crear detalles de venta para cada servicio
            foreach ($reserva->servicios as $servicio) {
                \App\Models\DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => null, // O puedes crear productos para servicios
                    'servicio_id' => $servicio->id,
                    'nombre_servicio' => $servicio->nombre,
                    'cantidad' => 1,
                    'precio' => $servicio->pivot->precio,
                    'subtotal' => $servicio->pivot->precio,
                ]);
            }

            \DB::commit();

            return redirect()->route('admin.reservas.index')
                ->with('success', 'Reserva marcada como realizada y venta registrada exitosamente. Total: $' . number_format($total, 2));

        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al procesar la reserva: ' . $e->getMessage());
        }
    }

}
