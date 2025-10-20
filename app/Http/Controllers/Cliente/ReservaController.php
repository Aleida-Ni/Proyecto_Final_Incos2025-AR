<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Barbero;
use Illuminate\Support\Facades\Log;
use App\Notifications\ReservaCanceladaToStaff;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

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
            // Excluir reservas canceladas para que las horas canceladas queden libres
            ->where('estado', '!=', 'cancelada')
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
        ->where('estado', '!=', 'cancelada')
        ->exists();

    if ($yaReservado) {
        return back()->withErrors(['hora' => 'Esta hora ya ha sido reservada.'])->withInput();
    }

    $reserva = Reserva::create([
        'barbero_id' => $request->barbero_id,
        'usuario_id' => auth()->id(),
        'fecha'      => $request->fecha,
        'hora'       => $request->hora,
        'estado'     => 'pendiente',
        'creado_en'  => now(),
        'actualizado_en' => now()
    ]);

    // Cargar la relación del barbero para el ticket
    $reserva->load('barbero');

    return redirect()
        ->route('cliente.barberos.index')
        ->with('success', 'Reserva realizada con éxito.')
        ->with('reserva_creada', $reserva->id); // ← CORREGIDO
}
    public function misReservas()
    {
        $reservas = Reserva::where('usuario_id', auth()->user()->id)
            ->with('barbero')
            ->latest()
            ->get();

        return view('cliente.reservas.index', compact('reservas'));
    }

    /**
     * Cancelar una reserva por el usuario dueño.
     */
    public function cancelar(Reserva $reserva)
    {
        // ownership check
        if ($reserva->usuario_id !== auth()->id()) {
            abort(403);
        }

        // Only allow cancel if not already completed/cancelled
        if (in_array($reserva->estado, ['realizada', 'cancelada', 'no_asistio'])) {
            return back()->with('error', 'No puedes cancelar esta reserva.');
        }

        // Optional: prevent cancellations within X hours (not applied by default)
        // $limiteHoras = 2; // example
        // if ($reserva->fecha->isToday() && now()->diffInHours($reserva->fecha) < $limiteHoras) { ... }

        $reserva->estado = 'cancelada';
        $reserva->actualizado_en = now();
        $reserva->save();

        // Log for debugging
        Log::info('Reserva cancelada por cliente', ['reserva_id' => $reserva->id, 'usuario_id' => auth()->id()]);

        // Notify admin(s) and the barbero assigned if exists
        try {
            $adminUsers = User::where('rol', 'admin')->get();
            $notifiables = $adminUsers;
            if ($reserva->barbero && $reserva->barbero->usuario_id) {
                $empleado = User::find($reserva->barbero->usuario_id);
                if ($empleado) {
                    $notifiables->push($empleado);
                }
            }

            Notification::send($notifiables, new ReservaCanceladaToStaff($reserva));
        } catch (\Exception $e) {
            Log::error('Error al notificar cancelacion de reserva: '.$e->getMessage());
        }

        return redirect()->route('cliente.reservas')->with('success', 'Reserva cancelada correctamente.');
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
