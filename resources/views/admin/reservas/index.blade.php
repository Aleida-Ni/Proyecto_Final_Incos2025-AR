@extends('adminlte::page')

@section('title', 'Gestión de Reservas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0"><i class="fas fa-calendar-alt text-gold"></i> Gestión de Reservas</h1>
        <div class="btn-group">
            <button type="button" class="btn btn-outline-custom dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-filter mr-2"></i> Filtrar
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('admin.reservas.index') }}">
                    <i class="fas fa-list mr-2"></i>Todas
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('admin.reservas.index', ['estado' => 'pendiente']) }}">
                    <i class="fas fa-clock mr-2 text-warning"></i>Pendientes
                </a>
                <a class="dropdown-item" href="{{ route('admin.reservas.index', ['estado' => 'realizada']) }}">
                    <i class="fas fa-check mr-2 text-success"></i>Realizadas
                </a>
                <a class="dropdown-item" href="{{ route('admin.reservas.index', ['estado' => 'cancelada']) }}">
                    <i class="fas fa-ban mr-2 text-danger"></i>Canceladas
                </a>
                <a class="dropdown-item" href="{{ route('admin.reservas.index', ['estado' => 'no_asistio']) }}">
                    <i class="fas fa-times mr-2 text-dark"></i>No Asistió
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('admin.reservas.index', ['fecha' => 'hoy']) }}">
                    <i class="fas fa-calendar-day mr-2 text-info"></i>Hoy
                </a>
                <a class="dropdown-item" href="{{ route('admin.reservas.index', ['fecha' => 'futuro']) }}">
                    <i class="fas fa-calendar-plus mr-2 text-primary"></i>Futuras
                </a>
                <a class="dropdown-item" href="{{ route('admin.reservas.index', ['fecha' => 'pasado']) }}">
                    <i class="fas fa-calendar-minus mr-2 text-secondary"></i>Pasadas
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <!-- Tarjetas de estadísticas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="small-box custom-card bg-primary">
                <div class="inner">
                    <h3>{{ $estadisticas['total'] ?? 0 }}</h3>
                    <p>Total Reservas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="small-box custom-card bg-warning">
                <div class="inner">
                    <h3>{{ $estadisticas['pendientes'] ?? 0 }}</h3>
                    <p>Pendientes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="small-box custom-card bg-success">
                <div class="inner">
                    <h3>{{ $estadisticas['hoy'] ?? 0 }}</h3>
                    <p>Hoy</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="small-box custom-card bg-info">
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

    <div class="card shadow-lg custom-card">
        <div class="card-header custom-card-header">
            <h3 class="card-title mb-0">
                <i class="fas fa-calendar-check mr-2"></i>
                Lista de Reservas
            </h3>
            <div class="card-tools">
                <a href="{{ route('admin.reservas.create') }}" class="btn btn-custom btn-sm">
                    <i class="fas fa-plus mr-2"></i>Nueva Reserva
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-custom">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-custom">
                <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <!-- TABLA MEJORADA -->
            <div class="table-responsive">
                <table class="table custom-table table-hover">
                    <thead>
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
                                    <div class="fw-bold text-gris-oscuro">{{ optional($r->cliente)->nombre ?? 'Cliente' }}</div>
                                    @if($r->cliente && $r->cliente->correo)
                                        <small class="text-gris-medio">{{ $r->cliente->correo }}</small>
                                    @endif
                                </td>
                                
                                <td class="align-middle">
                                    @if($r->cliente && $r->cliente->telefono)
                                        <small><i class="fas fa-phone text-beige-oscuro"></i> {{ $r->cliente->telefono }}</small>
                                    @else
                                        <small class="text-muted">Sin contacto</small>
                                    @endif
                                </td>
                                
                                <td class="align-middle">
                                    <span class="badge bg-secondary">{{ optional($r->barbero)->nombre ?? '—' }}</span>
                                </td>
                                
                                <td class="align-middle">
                                    <div class="fw-bold text-gris-oscuro">{{ $fechaReserva->format('d/m/Y') }}</div>
                                    <small class="text-gris-medio">{{ $fechaReserva->locale('es')->dayName }}</small>
                                </td>
                                
                                <td class="align-middle">
                                    <span class="fw-bold text-gris-oscuro">{{ $r->hora }}</span>
                                </td>
                                
                                <td class="align-middle">
                                    <span class="badge estado-badge 
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
                                            <span class="badge metodo-pago-badge
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
                                        <a href="{{ route('admin.reservas.show', $r) }}" class="btn btn-info" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($r->estado == 'pendiente')
                                            <a href="{{ route('admin.reservas.completar', $r) }}" 
                                               class="btn btn-success" 
                                               title="Completar reserva">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            
                                            <button type="button" 
                                                    class="btn btn-dark" 
                                                    data-toggle="modal" 
                                                    data-target="#modalNoAsistio{{ $r->id }}"
                                                    title="Marcar como no asistió">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            
                                            <button type="button" 
                                                    class="btn btn-danger" 
                                                    data-toggle="modal" 
                                                    data-target="#modalCancelar{{ $r->id }}"
                                                    title="Cancelar reserva">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Detalles -->
                            <div class="modal fade" id="modalDetalle{{ $r->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content custom-modal">
                                        <div class="modal-header custom-modal-header bg-primary">
                                            <h5 class="modal-title">
                                                <i class="fas fa-calendar-alt me-2"></i>Detalles Reserva #{{ $r->id }}
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
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
                                                        <span class="badge metodo-pago-badge
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
                                            <button type="button" class="btn btn-outline-custom" data-dismiss="modal">
                                                <i class="fas fa-times mr-1"></i>Cerrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal No Asistió -->
                            <div class="modal fade" id="modalNoAsistio{{ $r->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content custom-modal">
                                        <div class="modal-header custom-modal-header bg-dark">
                                            <h5 class="modal-title">Marcar como No Asistió</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Confirmar que el cliente <strong>{{ $r->cliente->nombre ?? 'Cliente' }}</strong> no asistió a su cita?</p>
                                            <p class="text-danger"><small>Esta acción no se puede deshacer.</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-custom" data-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('admin.reservas.marcar', [$r->id, 'no_asistio']) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-dark">
                                                    <i class="fas fa-times mr-1"></i>Confirmar No Asistió
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Cancelar -->
                            <div class="modal fade" id="modalCancelar{{ $r->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content custom-modal">
                                        <div class="modal-header custom-modal-header bg-danger">
                                            <h5 class="modal-title">Cancelar Reserva</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estás seguro de cancelar la reserva de <strong>{{ $r->cliente->nombre ?? 'Cliente' }}</strong>?</p>
                                            <p class="text-warning"><small>Esta acción no se puede deshacer.</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-custom" data-dismiss="modal">No cancelar</button>
                                            <form action="{{ route('admin.reservas.marcar', [$r->id, 'cancelada']) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-ban mr-1"></i>Sí, Cancelar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="fas fa-calendar-times fa-3x text-beige-oscuro mb-3"></i>
                                        <h4 class="text-gris-medio">No hay reservas</h4>
                                        <p class="text-muted">No se encontraron reservas con los filtros aplicados</p>
                                        <a href="{{ route('admin.reservas.create') }}" class="btn btn-custom mt-2">
                                            <i class="fas fa-plus mr-2"></i>Crear Primera Reserva
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
/* Estilos específicos para reservas */
.small-box.custom-card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    color: white;
    margin-bottom: 0;
}

.small-box.custom-card .inner {
    padding: 20px;
}

.small-box.custom-card .icon {
    font-size: 70px;
    opacity: 0.3;
    transition: all 0.3s ease;
}

.small-box.custom-card:hover .icon {
    opacity: 0.4;
    transform: scale(1.1);
}

.estado-badge, .metodo-pago-badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 12px;
}

.custom-modal {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.custom-modal-header {
    border-radius: 12px 12px 0 0;
    border-bottom: 2px solid rgba(255,255,255,0.2);
}

.empty-state {
    padding: 40px 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .small-box.custom-card .inner h3 {
        font-size: 1.5rem;
    }
    
    .small-box.custom-card .icon {
        font-size: 50px;
    }
    
    .btn-group-sm > .btn {
        padding: 0.25rem 0.4rem;
        font-size: 0.7rem;
    }
    
    .custom-table th,
    .custom-table td {
        padding: 8px 5px;
        font-size: 0.8rem;
    }
}
</style>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh cada 2 minutos
    setTimeout(function() {
        window.location.reload();
    }, 120000);

    // Tooltips
    $('[title]').tooltip();
});
</script>
@endsection