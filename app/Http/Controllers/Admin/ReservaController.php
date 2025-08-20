<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barbero;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ReservaController extends Controller
{
public function index()
{
    $reservas = Reserva::with(['cliente', 'barbero'])
        ->orderBy('creado_en', 'desc') // 👈 usa tu columna personalizada
        ->get();

    return view('admin.reservas.index', compact('reservas'));
}


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

        return redirect()->route('cliente.barberos')
            ->with('success', 'Reserva confirmada con éxito');
    }

}
