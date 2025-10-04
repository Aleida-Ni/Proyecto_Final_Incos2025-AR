@extends('adminlte::page')

@section('title', 'Gestión de Reservas')


@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Gestión de Reservas</h1>
    <div class="btn-group">
        <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fas fa-filter"></i> Filtrar
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('admin.reservas.index') }}">Todas</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="{{ route('admin.reservas.index', ['estado' => 'pendiente']) }}">Pendientes</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.reservas.index', ['estado' => 'realizada']) }}">Realizadas</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.reservas.index', ['estado' => 'cancelada']) }}">Canceladas</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.reservas.index', ['estado' => 'no_asistio']) }}">No Asistió</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="{{ route('admin.reservas.index', ['fecha' => 'hoy']) }}">Hoy</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.reservas.index', ['fecha' => 'futuro']) }}">Futuras</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.reservas.index', ['fecha' => 'pasado']) }}">Pasadas</a></li>
        </ul>
    </div>
</div>
@stop

@section('content')
<div class="row mb-4">
    <!-- Tarjetas de estadísticas -->
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $estadisticas['total'] ?? 0 }}</h4>
                        <p class="card-text">Total Reservas</p>
                    </div>
                    <i class="fas fa-calendar-alt fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $estadisticas['pendientes'] ?? 0 }}</h4>
                        <p class="card-text">Pendientes</p>
                    </div>
                    <i class="fas fa-clock fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $estadisticas['hoy'] ?? 0 }}</h4>
                        <p class="card-text">Hoy</p>
                    </div>
                    <i class="fas fa-calendar-day fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $estadisticas['esta_semana'] ?? 0 }}</h4>
                        <p class="card-text">Esta Semana</p>
                    </div>
                    <i class="fas fa-calendar-week fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Lista de Reservas</h5>
            <div class="text-muted small">
                <i class="fas fa-sync-alt"></i> Actualizado: {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="80">ID</th>
                        <th>Cliente</th>
                        <th>Barbero</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Contacto</th>
                        <th>Estado</th>
                        <th width="200">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    use Carbon\Carbon;
                    $now = Carbon::now();
                    $hoy = Carbon::today();
                    @endphp

                    @forelse($reservas as $r)
                    @php
                    $fechaHoraReserva = Carbon::parse($r->fecha . ' ' . $r->hora);
                    $pasada = $fechaHoraReserva->lt($now);
                    $esHoy = $fechaHoraReserva->isToday();
                    $esProximaHora = $fechaHoraReserva->diffInHours($now) <= 1 && !$pasada;
                        $claseFila='' ;

                        if ($pasada && $r->estado == 'pendiente') {
                        $claseFila = 'reserva-pasada';
                        } elseif ($esHoy && $r->estado == 'pendiente') {
                        $claseFila = 'reserva-hoy';
                        }
                        if ($esProximaHora && $r->estado == 'pendiente') {
                        $claseFila .= ' reserva-urgente';
                        }
                        @endphp

                        <tr class="{{ $claseFila }}">
                            <td>
                                <strong>#{{ $r->id }}</strong>
                            </td>
                            <td>
                                <div class="fw-bold">{{ optional($r->cliente)->nombre ?? 'Cliente' }}</div>
                                @if($r->cliente && $r->cliente->telefono)
                                <small class="text-muted">{{ $r->cliente->telefono }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ optional($r->barbero)->nombre ?? '—' }}</span>
                            </td>
                            <td>
                                <div class="fw-bold {{ $esHoy ? 'text-primary' : '' }}">
                                    {{ Carbon::parse($r->fecha)->format('d/m/Y') }}
                                </div>
                                <small class="text-muted">
                                    {{ Carbon::parse($r->fecha)->locale('es')->dayName }}
                                </small>
                            </td>
                            <td>
                                <span class="fw-bold {{ $esProximaHora ? 'text-danger' : '' }}">
                                    {{ $r->hora }}
                                </span>
                                @if($esProximaHora && !$pasada)
                                <br><small class="text-danger">¡Próxima!</small>
                                @endif
                            </td>
                            <td>
                                @if($r->cliente)
                                <small>
                                    <i class="fas fa-phone"></i> {{ $r->cliente->telefono ?? 'N/A' }}<br>
                                    <i class="fas fa-envelope"></i> {{ $r->cliente->correo ?? 'N/A' }}
                                </small>
                                @else
                                <small class="text-muted">Sin contacto</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge 
                                    @if($r->estado=='pendiente') bg-warning 
                                    @elseif($r->estado=='realizada') bg-success 
                                    @elseif($r->estado=='cancelada') bg-danger
                                    @elseif($r->estado=='no_asistio') bg-dark
                                    @endif">
                                    {{ ucfirst($r->estado) }}
                                </span>

                                {{-- Indicadores adicionales --}}
                                @if($r->estado == 'pendiente')
                                @if($pasada)
                                <br><small class="text-danger"><i class="fas fa-clock"></i> Hora pasada</small>
                                @elseif($esProximaHora)
                                <br><small class="text-success"><i class="fas fa-bell"></i> Próxima hora</small>
                                @endif
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    @if($r->estado == 'pendiente')
                                    <button type="button"
                                        class="btn btn-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalRealizada{{ $r->id }}"
                                        title="Marcar como realizada">
                                        <i class="fas fa-check"></i>
                                    </button>

                                    <button type="button"
                                        class="btn btn-dark"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalNoAsistio{{ $r->id }}"
                                        title="Marcar como no asistió">
                                        <i class="fas fa-times"></i>
                                    </button>

                                    <button type="button"
                                        class="btn btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalCancelar{{ $r->id }}"
                                        title="Cancelar reserva">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                    @else
                                    <span class="text-muted small">Completada</span>
                                    @endif

                                    <button type="button"
                                        class="btn btn-info"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalDetalle{{ $r->id }}"
                                        title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                                <!-- Modal para Marcar como Realizada -->
                                <div class="modal fade" id="modalRealizada{{ $r->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirmar Realización</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Confirmar que el cliente <strong>{{ $r->cliente->nombre ?? 'Cliente' }}</strong> asistió a su reserva?</p>
                                                <p><strong>Fecha:</strong> {{ Carbon::parse($r->fecha)->format('d/m/Y') }} a las {{ $r->hora }}</p>
                                                <p><strong>Barbero:</strong> {{ $r->barbero->nombre ?? '—' }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('admin.reservas.marcar', [$r->id, 'realizada']) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Sí, asistió</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal para Marcar como No Asistió -->
                                <div class="modal fade" id="modalNoAsistio{{ $r->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Marcar como No Asistió</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Marcar que el cliente <strong>{{ $r->cliente->nombre ?? 'Cliente' }}</strong> no asistió?</p>
                                                <p class="text-danger"><small>Esta acción no se puede deshacer.</small></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('admin.reservas.marcar', [$r->id, 'no_asistio']) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-dark">Sí, no asistió</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal para Cancelar -->
                                <div class="modal fade" id="modalCancelar{{ $r->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Cancelar Reserva</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Cancelar la reserva de <strong>{{ $r->cliente->nombre ?? 'Cliente' }}</strong>?</p>
                                                <p class="text-warning"><small>Esta acción notificará al cliente.</small></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No cancelar</button>
                                                <form action="{{ route('admin.reservas.marcar', [$r->id, 'cancelada']) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Sí, cancelar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal para Detalles -->
                                <div class="modal fade" id="modalDetalle{{ $r->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detalles de Reserva #{{ $r->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Cliente:</strong><br>
                                                        {{ $r->cliente->nombre ?? 'Cliente' }}<br>
                                                        <small class="text-muted">{{ $r->cliente->telefono ?? 'N/A' }}</small>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Barbero:</strong><br>
                                                        {{ $r->barbero->nombre ?? '—' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Fecha:</strong><br>
                                                        {{ Carbon::parse($r->fecha)->format('d/m/Y') }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Hora:</strong><br>
                                                        {{ $r->hora }}
                                                    </div>
                                                </div>
                                                <hr>
                                                                                                <div class="row">
                                                    <div class="col-12">
                                                        <strong>Estado:</strong><br>
                                                        <span class="badge 
                                                            @if($r->estado == 'pendiente') bg-warning
                                                            @elseif($r->estado == 'realizada') bg-success 
                                                            @elseif($r->estado == 'cancelada') bg-danger
                                                            @elseif($r->estado == 'no_asistio') bg-dark
                                                            @endif">
                                                            {{ ucfirst($r->estado) }}
                                                        </span>

                                                        {{-- Botón para marcar como realizada --}}
                                                        @if($r->estado == 'pendiente')
                                                            <a href="{{ route('admin.reservas.marcar-realizada', $r) }}"
                                                               class="btn btn-success btn-sm ms-1"
                                                               title="Marcar como realizada y registrar servicios">
                                                                <i class="fas fa-check"></i> Completar
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <strong>Creado:</strong><br>
                                                        {{ $r->creado_en->format('d/m/Y H:i') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No hay reservas</h5>
                                <p class="text-muted">No se encontraron reservas con los filtros aplicados</p>
                            </td>
                        </tr>
                        @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($reservas->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Mostrando {{ $reservas->firstItem() }} - {{ $reservas->lastItem() }} de {{ $reservas->total() }} reservas
            </div>
            {{ $reservas->links() }}
        </div>
        @endif
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-refresh cada 2 minutos para reservas pendientes
    setTimeout(() => {
        window.location.reload();
    }, 120000);

    // Notificación para reservas próximas
    document.addEventListener('DOMContentLoaded', function() {
        const reservasUrgentes = document.querySelectorAll('.reserva-urgente');
        if (reservasUrgentes.length > 0) {
            if (Notification.permission === "granted") {
                new Notification("Reservas próximas", {
                    body: `Tienes ${reservasUrgentes.length} reserva(s) en la próxima hora`,
                    icon: "/icon.png"
                });
            } else if (Notification.permission !== "denied") {
                Notification.requestPermission().then(permission => {
                    if (permission === "granted") {
                        new Notification("Reservas próximas", {
                            body: `Tienes ${reservasUrgentes.length} reserva(s) en la próxima hora`,
                            icon: "/icon.png"
                        });
                    }
                });
            }
        }
    });
</script>
@stop