<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barbero;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    /**
     * Listar todas las reservas
     */
public function index()
{
    Reserva::where('estado', 'pendiente')
        ->where(function($q) {
            $q->where('fecha', '<', now()->toDateString())
              ->orWhere(function($q2) {
                  $q2->where('fecha', now()->toDateString())
                     ->where('hora', '<', now()->format('H:i'));
              });
        })
        ->update(['estado' => 'no_asistio']);

    $reservas = Reserva::orderBy('fecha', 'desc')
        ->orderBy('hora', 'desc')
        ->get();

    return view('admin.reservas.index', compact('reservas'));
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
     * Marcar reserva como realizada
     */
    public function marcarRealizada(Reserva $reserva)
    {
        $reserva->update(['estado' => 'realizada']);

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva marcada como realizada.');
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
}
