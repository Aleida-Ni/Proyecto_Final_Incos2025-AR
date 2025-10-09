<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barbero;
use App\Models\Reserva;
use App\Models\Servicio;
use App\Models\ServicioReserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class ReservaController extends Controller
{
    /** Listar todas las reservas */
    public function index(Request $request)
    {
    $query = Reserva::with(['cliente', 'barbero', 'servicios']);

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

        // Estadísticas
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
        'metodo_pago' => 'required|in:efectivo,qr,transferencia',
        'monto_total' => 'required|numeric|min:0',
        'observaciones' => 'nullable|string|max:500'
    ]);

    DB::beginTransaction();

    try {
        // Actualizar reserva
        $reserva->update([
            'estado' => 'realizada',
            'observaciones' => $request->observaciones,
            'actualizado_en' => now()
        ]);

        // Registrar servicios
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
    public function store(Request $request)
    {
        $request->validate([
            'barbero_id' => 'required|exists:barberos,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'cliente_id' => 'required|exists:usuarios,id'
        ]);

        $yaReservada = Reserva::where('barbero_id', $request->barbero_id)
            ->where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->exists();

        if ($yaReservada) {
            return back()->withErrors(['hora' => 'Esa hora ya está reservada'])->withInput();
        }

        Reserva::create([
            'barbero_id' => $request->barbero_id,
            'usuario_id' => $request->cliente_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => 'pendiente',
        ]);

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva creada exitosamente.');
    }

    /** Mostrar */
public function show(Reserva $reserva)
{
    // Cargar relaciones necesarias
    $reserva->load(['cliente', 'barbero', 'servicios.servicio']);
    
    return view('admin.reservas.show', compact('reserva'));
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
