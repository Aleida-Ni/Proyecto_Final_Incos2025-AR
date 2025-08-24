@extends('cliente.layout')

@section('title', 'Mis Reservas')

@section('content')
<div class="container">
  <h3 class="mb-4">Mis Reservas</h3>

  <table class="table table-dark table-striped">
    <thead>
      <tr>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Barbero</th>
        <th>Estado</th>
      </tr>
    </thead>
    <tbody>
      @forelse($reservas as $reserva)
      <tr>
        <td>{{ $reserva->fecha }}</td>
        <td>{{ $reserva->hora }}</td>
        <td>{{ $reserva->barbero->nombre }}</td>

        <td>
          <button class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#ticketModal{{ $reserva->id }}">
            Ver Ticket
          </button>
        </td>
      </tr>

      <!-- Modal Ticket -->
      <div class="modal fade" id="ticketModal{{ $reserva->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $reserva->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content bg-dark text-white">
            <div class="modal-header">
              <h5 class="modal-title" id="modalLabel{{ $reserva->id }}">Ticket de Reserva</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              <p><strong>Barbero:</strong> {{ $reserva->barbero->nombre }}</p>
              @if($reserva->barbero->foto)
              <img src="{{ asset('storage/'.$reserva->barbero->foto) }}" alt="Foto del barbero" class="img-fluid rounded mb-3" style="max-height: 150px;">
              @endif
              <p><strong>Fecha:</strong> {{ $reserva->fecha }}</p>
              <p><strong>Hora:</strong> {{ $reserva->hora }}</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>

      @empty
      <tr>
        <td colspan="5">No tienes reservas registradas.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush
