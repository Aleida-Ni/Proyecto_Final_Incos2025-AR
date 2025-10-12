<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Barbero;

class ReservaController extends Controller
{
    public function create($barberoId, Request $request)
    {
        $barbero = Barbero::findOrFail($barberoId);
        $fecha = $request->input('fecha', now()->format('Y-m-d'));

        $horas = [
            '09:00' => true,
            '10:00' => true,
            '11:00' => true,
            '12:00' => true,
            '13:00' => true,
            '14:00' => true,
            '15:00' => true,
            '16:00' => true,
            '17:00' => true,
        ];

        $reservadas = Reserva::where('barbero_id', $barbero->id)
            ->where('fecha', $fecha)
            ->pluck('hora')
            ->toArray();

        foreach ($reservadas as $horaOcupada) {
            $horaOcupada = substr($horaOcupada, 0, 5);
            if (isset($horas[$horaOcupada])) {
                $horas[$horaOcupada] = false;
            }
        }

        return view('cliente.reservas.create', compact('barbero', 'fecha', 'horas'));
    }

 public function store(Request $request)
{
    $request->validate([
        'barbero_id' => 'required|exists:barberos,id',
        'fecha'      => 'required|date|after_or_equal:today',
        'hora'       => 'required|date_format:H:i',
    ]);

    $yaReservado = Reserva::where('barbero_id', $request->barbero_id)
        ->where('fecha', $request->fecha)
        ->where('hora', $request->hora)
        ->exists();

    if ($yaReservado) {
        return back()->withErrors(['hora' => 'Esta hora ya ha sido reservada.'])->withInput();
    }

    Reserva::create([
        'barbero_id' => $request->barbero_id,
        'usuario_id' => auth()->id(),  // ← CAMBIADO
        'fecha'      => $request->fecha,
        'hora'       => $request->hora,
        'estado'     => 'pendiente',  // ← Agregar estado por defecto
        'creado_en'  => now(),
        'actualizado_en' => now()
    ]);

    return redirect()
        ->route('cliente.barberos.index')
        ->with('success', 'Reserva realizada con éxito.');
}

    public function misReservas()
    {
        $reservas = Reserva::where('usuario_id', auth()->user()->id)
            ->with('barbero')
            ->latest()
            ->get();

        return view('cliente.reservas.index', compact('reservas'));
    }

    public function ticket($id)
    {
        $reserva = Reserva::with('barbero')
            ->where('usuario_id', auth()->id())
            ->findOrFail($id);

        return view('cliente.reservas.ticket', compact('reserva'));
    }

    public function inicio()
    {
        return view('cliente.home');
    }
    public function generarTicket(Request $request, Barbero $barbero)
{
    $request->validate([
        'fecha' => 'required|date',
        'hora' => 'required',
    ]);

    $fecha = $request->fecha;
    $hora = $request->hora;

    return view('cliente.reservas.ticket', compact('barbero', 'fecha', 'hora'));
}

}
