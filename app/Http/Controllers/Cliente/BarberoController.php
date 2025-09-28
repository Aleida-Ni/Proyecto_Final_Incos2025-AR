<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barbero;
use App\Models\Reserva;


class BarberoController extends Controller
{

public function index(Request $request)
{
    $query = Barbero::query();

    if ($request->filled('fecha') && $request->filled('hora')) {
        // Aquí iría tu lógica para filtrar barberos disponibles en esa fecha y hora
        $query->whereDoesntHave('reservas', function ($q) use ($request) {
            $q->where('fecha', $request->fecha)
              ->where('hora', $request->hora);
        });
    }

    $barberos = $query->get();

    return view('cliente.barberos.index', compact('barberos'));
}


    public function create() 
    {
        
    }

    public function store(Request $request)
    {


    }

    public function edit(Barbero $barbero)
    {

    }

    public function update(Request $request, Barbero $barbero)
    {


    }

    public function destroy(Barbero $barbero)
    {

    }

    public function clienteIndex()
    {
        $barberos = Barbero::all();
        return view('cliente.barberos.index', compact('barberos'));
    }
}
