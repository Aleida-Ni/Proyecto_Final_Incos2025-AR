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
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($reservas as $reserva)
      <tr>
        <td>{{ $reserva->fecha }}</td>
        <td>{{ $reserva->hora }}</td>
        <td>{{ $reserva->barbero->nombre }}</td>
        <td>
          @php
            $badgeClass = 'bg-secondary';
            switch($reserva->estado) {
              case 'pendiente': $badgeClass = 'bg-warning text-dark'; break;
              case 'confirmada': $badgeClass = 'bg-success'; break;
              case 'realizada': $badgeClass = 'bg-primary'; break;
              case 'no_asistio': $badgeClass = 'bg-dark'; break;
              case 'cancelada': $badgeClass = 'bg-danger'; break;
            }
          @endphp
          <span class="badge {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $reserva->estado)) }}</span>
        </td>

        <td>
          <button class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#ticketModal{{ $reserva->id }}">
            Ver Ticket
          </button>
          @if($reserva->estado == 'pendiente')
          <button class="btn btn-outline-danger btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#modalCancelar{{ $reserva->id }}">
            <i class="fas fa-times"></i> Cancelar
          </button>
          @endif
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
              @if($reserva->estado == 'pendiente')
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalCancelar{{ $reserva->id }}">Cancelar reserva</button>
              @endif
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Cancelar (cliente) -->
      <div class="modal fade" id="modalCancelar{{ $reserva->id }}" tabindex="-1" aria-labelledby="modalCancelarLabel{{ $reserva->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalCancelarLabel{{ $reserva->id }}">Cancelar Reserva</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              <p>¿Estás seguro que deseas cancelar la reserva para <strong>{{ $reserva->fecha }} {{ $reserva->hora }}</strong> con <strong>{{ $reserva->barbero->nombre }}</strong>?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, mantener</button>
              <form method="POST" action="{{ route('cliente.reservas.cancelar', $reserva->id) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger">Sí, cancelar</button>
              </form>
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
