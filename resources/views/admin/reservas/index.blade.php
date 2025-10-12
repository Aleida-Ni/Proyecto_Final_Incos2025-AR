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
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('admin.reservas.index', ['estado' => 'pendiente']) }}">Pendientes</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.reservas.index', ['estado' => 'realizada']) }}">Realizadas</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.reservas.index', ['estado' => 'cancelada']) }}">Canceladas</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.reservas.index', ['estado' => 'no_asistio']) }}">No Asistió</a></li>
            <li><hr class="dropdown-divider"></li>
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
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $estadisticas['total'] ?? 0 }}</h3>
                <p>Total Reservas</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $estadisticas['pendientes'] ?? 0 }}</h3>
                <p>Pendientes</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $estadisticas['hoy'] ?? 0 }}</h3>
                <p>Hoy</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-day"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $estadisticas['esta_semana'] ?? 0 }}</h3>
                <p>Esta Semana</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-week"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-calendar-check mr-1"></i>
            Lista de Reservas
        </h3>
        <div class="card-tools">
            <div class="btn-group">
                <a href="{{ route('admin.reservas.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nueva Reserva
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- TABLA MEJORADA -->
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablaReservas">
                <thead class="table-dark">
                    <tr>
                        <th width="180">Cliente</th>
                        <th width="120">Contacto</th>
                        <th width="120">Barbero</th>
                        <th width="100">Fecha</th>
                        <th width="80">Hora</th>
                        <th width="120">Estado</th>
                        <th width="150">Pago y Método</th>
                        <th width="120" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservas as $r)
                        @php
                            $fechaReserva = \Carbon\Carbon::parse($r->fecha);
                            $esPasada = $fechaReserva->lt(\Carbon\Carbon::today());
                            $totalReserva = $r->venta ? $r->venta->total : $r->servicios->sum('precio');
                            $metodoPago = $r->metodo_pago ?? ($r->venta->metodo_pago ?? null);
                        @endphp
                        
                        <tr class="{{ $esPasada && $r->estado == 'pendiente' ? 'table-warning' : '' }}">

                            
                            <td class="align-middle">
                                <div class="fw-bold">{{ optional($r->cliente)->nombre ?? 'Cliente' }}</div>
                                @if($r->cliente && $r->cliente->correo)
                                    <small class="text-muted">{{ $r->cliente->correo }}</small>
                                @endif
                            </td>
                            
                            <td class="align-middle">
                                @if($r->cliente && $r->cliente->telefono)
                                    <small><i class="fas fa-phone"></i> {{ $r->cliente->telefono }}</small>
                                @else
                                    <small class="text-muted">Sin contacto</small>
                                @endif
                            </td>
                            
                            <td class="align-middle">
                                <span class="badge bg-secondary">{{ optional($r->barbero)->nombre ?? '—' }}</span>
                            </td>
                            
                            <td class="align-middle">
                                <div class="fw-bold">{{ $fechaReserva->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $fechaReserva->locale('es')->dayName }}</small>
                            </td>
                            
                            <td class="align-middle">
                                <span class="fw-bold">{{ $r->hora }}</span>
                            </td>
                            
                            <td class="align-middle">
                                <span class="badge 
                                    @if($r->estado=='pendiente') bg-warning 
                                    @elseif($r->estado=='realizada') bg-success 
                                    @elseif($r->estado=='cancelada') bg-danger
                                    @elseif($r->estado=='no_asistio') bg-dark
                                    @endif">
                                    {{ ucfirst($r->estado) }}
                                </span>
                                @if($esPasada && $r->estado == 'pendiente')
                                    <br><small class="text-danger"><i class="fas fa-clock"></i> Pasada</small>
                                @endif
                            </td>
                            
                            <td class="align-middle">
                                @if($totalReserva > 0)
                                    <div class="fw-bold text-success">${{ number_format($totalReserva, 2) }}</div>
                                    @if($metodoPago)
                                        <span class="badge 
                                            @if($metodoPago == 'efectivo') bg-success
                                            @elseif($metodoPago == 'qr') bg-primary
                                            @elseif($metodoPago == 'transferencia') bg-info
                                            @else bg-secondary @endif">
                                            {{ ucfirst($metodoPago) }}
                                        </span>
                                    @else
                                        <small class="text-muted">Sin método</small>
                                    @endif
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            
                            <td class="align-middle text-center">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalDetalle{{ $r->id }}"
                                            title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    @if($r->estado == 'pendiente')
                                        <a href="{{ route('admin.reservas.completar', $r) }}" 
                                           class="btn btn-success" 
                                           title="Completar reserva">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        
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
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Detalles -->
                        <div class="modal fade" id="modalDetalle{{ $r->id }}" tabindex="-1" aria-labelledby="modalDetalleLabel{{ $r->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="modalDetalleLabel{{ $r->id }}">
                                            <i class="fas fa-calendar-alt me-2"></i>Detalles Reserva #{{ $r->id }}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <strong>Cliente:</strong> {{ $r->cliente->nombre ?? 'Cliente no registrado' }}<br>
                                                <strong>Teléfono:</strong> {{ $r->cliente->telefono ?? 'N/A' }}<br>
                                                <strong>Email:</strong> {{ $r->cliente->correo ?? 'N/A' }}
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Barbero:</strong> {{ $r->barbero->nombre ?? 'No asignado' }}<br>
                                                <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($r->fecha)->format('d/m/Y') }}<br>
                                                <strong>Hora:</strong> {{ $r->hora }}<br>
                                                @if($r->estado == 'realizada' && $metodoPago)
                                                    <strong>Método de Pago:</strong> 
                                                    <span class="badge 
                                                        @if($metodoPago == 'efectivo') bg-success
                                                        @elseif($metodoPago == 'qr') bg-primary
                                                        @elseif($metodoPago == 'transferencia') bg-info
                                                        @endif">
                                                        {{ ucfirst($metodoPago) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="mb-3">
                                            <strong>Servicios:</strong>
                                            @if($r->servicios && $r->servicios->count() > 0)
                                                <ul class="list-group mt-2">
                                                    @foreach($r->servicios as $servicioReserva)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            {{ $servicioReserva->servicio->nombre ?? 'Servicio no encontrado' }}
                                                            <span class="badge bg-primary">
                                                                ${{ number_format($servicioReserva->precio, 2) }}
                                                            </span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="mt-2 text-end">
                                                    <strong>Total: ${{ number_format($r->servicios->sum('precio'), 2) }}</strong>
                                                </div>
                                            @else
                                                <p class="text-muted mt-2">No hay servicios registrados</p>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-1"></i>Cerrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal No Asistió -->
                        <div class="modal fade" id="modalNoAsistio{{ $r->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-dark text-white">
                                        <h5 class="modal-title">Marcar como No Asistió</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Confirmar que el cliente <strong>{{ $r->cliente->nombre ?? 'Cliente' }}</strong> no asistió a su cita?</p>
                                        <p class="text-danger"><small>Esta acción no se puede deshacer.</small></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('admin.reservas.marcar', [$r->id, 'no_asistio']) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-dark">
                                                <i class="fas fa-times me-1"></i>Confirmar No Asistió
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Cancelar -->
                        <div class="modal fade" id="modalCancelar{{ $r->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title">Cancelar Reserva</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Estás seguro de cancelar la reserva de <strong>{{ $r->cliente->nombre ?? 'Cliente' }}</strong>?</p>
                                        <p class="text-warning"><small>Esta acción no se puede deshacer.</small></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No cancelar</button>
                                        <form action="{{ route('admin.reservas.marcar', [$r->id, 'cancelada']) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-ban me-1"></i>Sí, Cancelar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No hay reservas</h5>
                                <p class="text-muted">No se encontraron reservas con los filtros aplicados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    </div>
</div>
@stop

@section('css')
<style>
.table td { vertical-align: middle; }
.btn-group-sm > .btn { padding: .25rem .5rem; }
.badge { font-size: 85%; }

.modal-content {
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    border-radius: 10px;
}

.modal-header {
    border-radius: 10px 10px 0 0;
}

.small-box .icon {
    font-size: 70px;
    opacity: 0.2;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,123,255,0.075);
}
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        window.location.reload();
    }, 120000);

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@stop