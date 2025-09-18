@extends('adminlte::page')

@section('title', 'Reservas')

@section('content')
<h1 class="neon-title text-center mb-4">Reservas realizadas</h1>

<div class="card shadow-sm neon-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table neon-table table-hover table-bordered text-center align-middle">
                <thead class="neon-thead">
                    <tr>
                        <th>Cliente</th>
                        <th>Barbero</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                        <th>Creado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservas as $reserva)
                    <tr>
                        <!-- Cliente con modal -->
                        <td>
                            <button class="btn btn-link p-0 neon-link" data-bs-toggle="modal" data-bs-target="#clienteModal{{ $reserva->id }}">
                                {{ $reserva->cliente->name }}
                            </button>

                            <!-- Modal cliente -->
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

                        <!-- Barbero -->
                        <td>{{ $reserva->barbero->nombre }}</td>

                        <!-- Fecha y Hora -->
                        <td>{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $reserva->hora }}</td>

                        <!-- Estado -->
                        <td>
                            <span class="badge 
                                @if($reserva->estado === 'pendiente') bg-warning 
                                @elseif($reserva->estado === 'realizada') bg-success 
                                @else bg-danger @endif">
                                {{ ucfirst($reserva->estado) }}
                            </span>
                        </td>

                        <!-- Acciones -->
                        <td>
                            @if($reserva->estado === 'pendiente')
                                <form action="{{ route('admin.reservas.realizada', $reserva) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">✅ Realizada</button>
                                </form>

                                <form action="{{ route('admin.reservas.cancelada', $reserva) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm">❌ Cancelar</button>
                                </form>
                            @else
                                <em>No disponible</em>
                            @endif
                        </td>

                        <!-- Creado en -->
                        <td>{{ \Carbon\Carbon::parse($reserva->created_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    /* Título neón */
    .neon-title {
        color: #39ff14;
        text-shadow:
            0 0 5px #39ff14,
            0 0 10px #39ff14,
            0 0 20px #39ff14,
            0 0 40px #0fa,
            0 0 80px #0fa,
            0 0 90px #0fa,
            0 0 100px #0fa;
        font-weight: 700;
    }

    /* Tabla neón */
    .neon-table {
        border: 2px solid #39ff14;
    }

    .neon-thead th {
        background-color: #0c0c0c;
        color: #39ff14;
        border-bottom: 2px solid #39ff14;
    }

    .neon-table td, .neon-table th {
        border: 1px solid #39ff14;
    }

    .neon-card {
        border: 2px solid #39ff14;
        box-shadow: 0 0 20px #39ff14;
    }

    .neon-link {
        color: #39ff14 !important;
        text-shadow: 0 0 5px #39ff14;
        text-decoration: none !important;
    }

    .neon-link:hover {
        color: #0fa !important;
        text-shadow: 0 0 10px #0fa;
    }
</style>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush
