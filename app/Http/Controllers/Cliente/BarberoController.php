<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barbero;
use App\Models\Reserva;


class BarberoController extends Controller
{

public function index()
{
    $barberos = Barbero::all();

    // Obtener reservas del cliente actual
    $reservas = Reserva::where('usuario_id', auth()->id())
        ->with('barbero')
        ->latest()
        ->get();

    return view('cliente.barberos.index', compact('barberos', 'reservas'));
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
