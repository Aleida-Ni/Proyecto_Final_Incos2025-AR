@extends('adminlte::page')

@section('title', 'Ticket de Reserva')

@section('content')
<div class="container mt-4">
  <div class="card">
    <div class="card-header bg-dark text-white">Detalle de Reserva</div>
    <div class="card-body">
      <p><strong>Barbero:</strong> {{ $reserva->barbero->nombre }}</p>
      <p><strong>Fecha:</strong> {{ $reserva->fecha }}</p>
      <p><strong>Hora:</strong> {{ $reserva->hora }}</p>
      <p><strong>Estado:</strong>
        @if($reserva->estado == 'pendiente')
          <span class="badge bg-warning">Pendiente</span>
        @elseif($reserva->estado == 'confirmada')
          <span class="badge bg-success">Confirmada</span>
        @else
          <span class="badge bg-danger">Rechazada</span>
        @endif
      </p>
      <a href="{{ route('cliente.reservas') }}" class="btn btn-secondary">Volver</a>
    </div>
  </div>
</div>
@endsection
