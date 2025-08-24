@extends('adminlte::page')

@section('title', 'Ticket de Reserva')

@section('content')
<div class="container mt-4">
  <div class="card">
    <div class="card-header bg-dark text-white">Detalle de Reserva</div>
    <div class="card-body">
      <p><strong>Barbero:</strong> {{ $reserva->barbero->nombre }}</p>
      @if($reserva->barbero->foto)
      <img src="{{ asset('storage/'.$reserva->barbero->foto) }}" alt="Foto del barbero" class="img-fluid rounded mb-3" style="max-height: 150px;">
      @endif
      <p><strong>Fecha:</strong> {{ $reserva->fecha }}</p>
      <p><strong>Hora:</strong> {{ $reserva->hora }}</p>

      <a href="{{ route('cliente.reservas') }}" class="btn btn-secondary">Volver</a>
    </div>
  </div>
</div>
@endsection
