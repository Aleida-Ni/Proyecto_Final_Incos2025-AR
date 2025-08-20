@extends('adminlte::page')

@section('title', 'Reservas')

@section('content')
<h1 class="text-black text-center mb-4">Reservas realizadas</h1>

<div class="table-container mx-auto">
    <table class="table custom-table">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Barbero</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Creado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservas as $reserva)
            <tr>
<td>
    <button class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#clienteModal{{ $reserva->id }}">
        {{ $reserva->cliente->name }}
    </button>

    <!-- Modal -->
    <div class="modal fade" id="clienteModal{{ $reserva->id }}" tabindex="-1" aria-labelledby="clienteModalLabel{{ $reserva->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="clienteModalLabel{{ $reserva->id }}">Datos del Cliente</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nombre:</strong> {{ $reserva->cliente->name }}</p>
                    <p><strong>Email:</strong> {{ $reserva->cliente->email }}</p>
                    <p><strong>Teléfono:</strong> {{ $reserva->cliente->telefono ?? 'No registrado' }}</p>
                </div>
            </div>
        </div>
    </div>
</td>
                <td>{{ $reserva->barbero->nombre }}</td>
                <td>{{ $reserva->fecha }}</td>
                <td>{{ $reserva->hora }}</td>
<td>{{ $reserva->creado_en ? \Carbon\Carbon::parse($reserva->creado_en)->format('d/m/Y H:i') : 'Sin fecha' }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('css')
<style>
    /* Título negro */
    h1.text-black {
        color: black !important;
    }
</style>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush
