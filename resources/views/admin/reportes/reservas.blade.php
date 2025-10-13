@extends('adminlte::page')

@section('title', 'Reportes - Reservas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Reporte de Reservas</h1>
        <div>
            <button class="btn btn-success btn-sm" onclick="exportToExcel()">
                <i class="fas fa-file-excel"></i> Exportar Excel
            </button>
            <a href="{{ route('admin.reportes.reservas.pdf', request()->query()) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-file-pdf"></i> Exportar PDF
            </a>
            <button class="btn btn-danger btn-sm" onclick="window.print()">
                <i class="fas fa-print"></i> Imprimir
            </button>
        </div>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <!-- FILTROS MEJORADOS -->
        <form method="GET" class="row g-3 mb-4 align-items-end" id="filterForm">
            <!-- Filtros rápidos -->
            <div class="col-md-2">
                <label class="form-label">Periodo rápido</label>
                <select name="periodo" class="form-select">
                    <option value="">-- Seleccionar --</option>
                    <option value="hoy" {{ request('periodo') == 'hoy' ? 'selected' : '' }}>Hoy</option>
                    <option value="7" {{ request('periodo') == '7' ? 'selected' : '' }}>Últimos 7 días</option>
                    <option value="15" {{ request('periodo') == '15' ? 'selected' : '' }}>Últimos 15 días</option>
                    <option value="30" {{ request('periodo') == '30' ? 'selected' : '' }}>Últimos 30 días</option>
                    <option value="mes" {{ request('periodo') == 'mes' ? 'selected' : '' }}>Este mes</option>
                    <option value="mes_pasado" {{ request('periodo') == 'mes_pasado' ? 'selected' : '' }}>Mes pasado</option>
                </select>
            </div>

            <!-- Filtro personalizado -->
            <div class="col-md-2">
                <label class="form-label">Desde</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}" id="fechaDesde">
            </div>
            <div class="col-md-2">
                <label class="form-label">Hasta</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}" id="fechaHasta">
            </div>

            <!-- Estado (oculto, se maneja por los botones) -->
            <input type="hidden" name="estado" id="estadoFilter" value="{{ request('estado') }}">

            <!-- Barbero -->
            <div class="col-md-2">
                <label class="form-label">Barbero</label>
                <select name="barbero_id" class="form-select">
                    <option value="">Todos</option>
                    @foreach($barberos as $barbero)
                        <option value="{{ $barbero->id }}" {{ request('barbero_id') == $barbero->id ? 'selected' : '' }}>
                            {{ $barbero->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Botones -->
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
                <a href="{{ route('admin.reportes.reservas') }}" class="btn btn-outline-secondary w-100 mt-1">
                    <i class="fas fa-undo"></i> Limpiar
                </a>
            </div>
        </form>

        <!-- MÉTRICAS Y ESTADÍSTICAS INTERACTIVAS -->
        @if(isset($estadisticas))
        <div class="row mb-4">
            <!-- Total Reservas -->
            <div class="col-md-2">
                <div class="card metric-card bg-primary text-white clickable-card" 
                     onclick="filterByStatus('')"
                     data-status="">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['total'] }}</h3>
                        <p class="card-text mb-0">
                            <i class="fas fa-calendar-alt me-1"></i>Total Reservas
                        </p>
                        <small class="opacity-75">Click para ver todas</small>
                    </div>
                </div>
            </div>
            
            <!-- Pendientes -->
            <div class="col-md-2">
                <div class="card metric-card bg-warning text-white clickable-card {{ request('estado') == 'pendiente' ? 'active-metric' : '' }}" 
                     onclick="filterByStatus('pendiente')"
                     data-status="pendiente">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['pendientes'] }}</h3>
                        <p class="card-text mb-0">
                            <i class="fas fa-clock me-1"></i>Pendientes
                        </p>
                        <small class="opacity-75">
                            @if($estadisticas['ingreso_pendiente'] > 0)
                            ${{ number_format($estadisticas['ingreso_pendiente'], 2) }}
                            @else
                            Sin ingresos
                            @endif
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Realizadas -->
            <div class="col-md-2">
                <div class="card metric-card bg-success text-white clickable-card {{ request('estado') == 'realizada' ? 'active-metric' : '' }}" 
                     onclick="filterByStatus('realizada')"
                     data-status="realizada">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['realizadas'] }}</h3>
                        <p class="card-text mb-0">
                            <i class="fas fa-check-circle me-1"></i>Realizadas
                        </p>
                        <small class="opacity-75">
                            ${{ number_format($estadisticas['ingreso_realizado'], 2) }}
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Canceladas -->
            <div class="col-md-2">
                <div class="card metric-card bg-danger text-white clickable-card {{ request('estado') == 'cancelada' ? 'active-metric' : '' }}" 
                     onclick="filterByStatus('cancelada')"
                     data-status="cancelada">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['canceladas'] }}</h3>
                        <p class="card-text mb-0">
                            <i class="fas fa-ban me-1"></i>Canceladas
                        </p>
                        <small class="opacity-75">
                            {{ $estadisticas['tasa_cancelacion'] }}% tasa
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- No Asistió -->
            <div class="col-md-2">
                <div class="card metric-card bg-dark text-white clickable-card {{ request('estado') == 'no_asistio' ? 'active-metric' : '' }}" 
                     onclick="filterByStatus('no_asistio')"
                     data-status="no_asistio">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['no_asistio'] }}</h3>
                        <p class="card-text mb-0">
                            <i class="fas fa-times me-1"></i>No Asistió
                        </p>
                        <small class="opacity-75">
                            {{ $estadisticas['tasa_no_asistencia'] }}% tasa
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Tasa Asistencia -->
            <div class="col-md-2">
                <div class="card metric-card bg-info text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['tasa_asistencia'] }}%</h3>
                        <p class="card-text mb-0">
                            <i class="fas fa-chart-line me-1"></i>Tasa Asistencia
                        </p>
                        <small class="opacity-75">
                            Total: ${{ number_format($estadisticas['ingreso_total'], 2) }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- RESUMEN FINANCIERO -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-light">
                    <div class="card-body py-2">
                        <div class="row text-center">
                            <div class="col-md-3 border-end">
                                <small class="text-muted">Ingreso Total Realizado</small>
                                <h5 class="mb-0 text-success">${{ number_format($estadisticas['ingreso_total'], 2) }}</h5>
                            </div>
                            <div class="col-md-3 border-end">
                                <small class="text-muted">Ingreso Pendiente</small>
                                <h5 class="mb-0 text-warning">${{ number_format($estadisticas['ingreso_pendiente'], 2) }}</h5>
                            </div>
                            <div class="col-md-3 border-end">
                                <small class="text-muted">Promedio por Reserva</small>
                                <h5 class="mb-0 text-primary">${{ number_format($estadisticas['promedio_reserva'], 2) }}</h5>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Reservas por Día</small>
                                <h5 class="mb-0 text-info">{{ number_format($estadisticas['reservas_por_dia'], 1) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- RESUMEN DEL REPORTE -->
        @if($reservas->count() > 0)
        <div class="alert alert-info mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>Reporte generado:</strong> 
                    {{ request('from') ? \Carbon\Carbon::parse(request('from'))->format('d/m/Y') : 'Inicio' }} 
                    al 
                    {{ request('to') ? \Carbon\Carbon::parse(request('to'))->format('d/m/Y') : 'Actual' }}
                    @if(request('estado'))
                    | <strong>Estado:</strong> 
                    <span class="badge 
                        @if(request('estado') == 'pendiente') bg-warning 
                        @elseif(request('estado') == 'realizada') bg-success 
                        @elseif(request('estado') == 'cancelada') bg-danger
                        @elseif(request('estado') == 'no_asistio') bg-dark
                        @endif">
                        {{ ucfirst(request('estado')) }}
                    </span>
                    @endif
                </div>
                <div>
                    <strong>Total registros:</strong> {{ $reservas->total() }}
                </div>
            </div>
        </div>
        @endif

        <!-- TABLA MEJORADA -->
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablaReservas">
                <thead class="table-dark">
                    <tr>
                        <th width="80">ID</th>
                        <th>Cliente</th>
                        <th>Contacto</th>
                        <th>Barbero</th>
                        <th width="110">Fecha</th>
                        <th width="90">Hora</th>
                        <th width="120">Estado</th>
                        <th width="120">Monto</th>
                        <th width="100" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservas as $r)
                        @php
                            $fechaReserva = \Carbon\Carbon::parse($r->fecha);
                            $esPasada = $fechaReserva->lt(\Carbon\Carbon::today());
                            $totalReserva = 0;
                            
                            // Calcular total de la reserva
                            if ($r->servicios && $r->servicios->count() > 0) {
                                $totalReserva = $r->servicios->sum('pivot.precio');
                            }
                            
                            // Si tiene venta asociada, usar ese monto
                            if ($r->venta) {
                                $totalReserva = $r->venta->total;
                            }
                        @endphp
                        <tr class="{{ $esPasada && $r->estado == 'pendiente' ? 'table-warning' : '' }}">
                            <td>
                                <strong>#{{ $r->id }}</strong>
                            </td>
                            <td>
                                <div class="fw-bold">{{ optional($r->cliente)->nombre ?? 'Cliente' }}</div>
                                <small class="text-muted">{{ optional($r->cliente)->correo ?? '' }}</small>
                            </td>
                            <td>
                                @if($r->cliente && $r->cliente->telefono)
                                    <small>
                                        <i class="fas fa-phone"></i> {{ $r->cliente->telefono }}
                                    </small>
                                @else
                                    <small class="text-muted">Sin contacto</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ optional($r->barbero)->nombre ?? '—' }}</span>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $fechaReserva->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $fechaReserva->locale('es')->dayName }}</small>
                            </td>
                            <td>
                                <span class="fw-bold">{{ $r->hora }}</span>
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
                                @if($esPasada && $r->estado == 'pendiente')
                                    <br><small class="text-danger"><i class="fas fa-clock"></i> Pasada</small>
                                @endif
                            </td>
                            <td>
                                @php
                                    $totalReserva = 0;
                                    // Si tiene venta asociada, usar ese monto
                                    if ($r->venta) {
                                        $totalReserva = $r->venta->total;
                                    } else {
                                        // Si no tiene venta, calcular de servicios
                                        $totalReserva = $r->servicios->sum('pivot.precio');
                                    }
                                @endphp
                                
                                @if($totalReserva > 0)
                                    <strong class="text-success">${{ number_format($totalReserva, 2) }}</strong>
                                    @if($r->venta && $r->venta->metodo_pago)
                                    <br><small class="text-muted">{{ ucfirst($r->venta->metodo_pago) }}</small>
                                    @elseif($r->estado == 'pendiente')
                                    <br><small class="text-warning">Pendiente</small>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-info btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalDetalle{{ $r->id }}"
                                        title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if($r->estado == 'pendiente')
                                    <a href="{{ route('admin.reservas.completar', $r) }}" 
                                       class="btn btn-success btn-sm" 
                                       title="Completar reserva">
                                        <i class="fas fa-check"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal Detalles -->
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
                        <strong>Hora:</strong> {{ $r->hora }}
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Estado:</strong>
                        <span class="badge 
                            @if($r->estado=='pendiente') bg-warning 
                            @elseif($r->estado=='realizada') bg-success 
                            @elseif($r->estado=='cancelada') bg-danger
                            @elseif($r->estado=='no_asistio') bg-dark
                            @endif">
                            {{ ucfirst($r->estado) }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <strong>Monto:</strong>
                        @php
                            if ($r->venta) {
                                $totalReserva = $r->venta->total;
                            } else {
                                $totalReserva = $r->servicios->sum(function($servicio) {
                                    return $servicio->pivot->precio ?? 0;
                                });
                            }
                        @endphp
                        <span class="fw-bold text-success">${{ number_format($totalReserva, 2) }}</span>
                        @if($r->venta && $r->venta->metodo_pago)
                            <br><small class="text-muted">Pago: {{ ucfirst($r->venta->metodo_pago) }}</small>
                        @elseif($r->estado == 'pendiente')
                            <br><small class="text-warning">Pendiente</small>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="mb-3">
                    <strong>Servicios Realizados:</strong>
                    @if($r->servicios && $r->servicios->count() > 0)
                        <ul class="list-group mb-2">
                            @foreach($r->servicios as $servicioReserva)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $servicioReserva->nombre ?? ($servicioReserva->servicio->nombre ?? 'Servicio') }}
                                    <span class="badge bg-info">
                                        ${{ number_format($servicioReserva->pivot->precio ?? $servicioReserva->precio, 2) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No se registraron servicios para esta reserva.
                        </div>
                    @endif
                </div>
                @if($r->observaciones)
                <hr>
                <div class="mb-3">
                    <strong>Observaciones:</strong>
                    <div class="card">
                        <div class="card-body">
                            {{ $r->observaciones }}
                        </div>
                    </div>
                </div>
                @endif
                <hr>
                <div class="row text-muted small">
                    <div class="col-md-6">
                        <strong>Creado:</strong> {{ $r->creado_en->format('d/m/Y H:i') }}
                    </div>
                    @if($r->actualizado_en)
                    <div class="col-md-6 text-end">
                        <strong>Actualizado:</strong> {{ $r->actualizado_en->format('d/m/Y H:i') }}
                    </div>
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
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No se encontraron reservas</h5>
                                <p class="text-muted">No hay registros con los filtros aplicados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINACIÓN -->
        @if($reservas->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Mostrando {{ $reservas->firstItem() }} - {{ $reservas->lastItem() }} de {{ $reservas->total() }} registros
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
// Función para filtrar por estado al hacer clic en las métricas
function filterByStatus(status) {
    console.log('Filtrando por estado:', status);
    
    // Establecer el valor del filtro de estado
    document.getElementById('estadoFilter').value = status;
    
    // Enviar el formulario
    document.getElementById('filterForm').submit();
}

// Función para limpiar todos los filtros
function limpiarFiltros() {
    document.getElementById('estadoFilter').value = '';
    document.getElementById('filterForm').submit();
}

// Función para exportar a Excel
function exportToExcel() {
    const tabla = document.getElementById('tablaReservas');
    let csv = [];
    const rows = tabla.querySelectorAll('tr');
    
    for (let i = 0; i < rows.length; i++) {
        let row = [], cols = rows[i].querySelectorAll('td, th');
        
        for (let j = 0; j < cols.length - 1; j++) { // Excluir columna acciones
            let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, "").replace(/(\s\s)/gm, " ");
            row.push('"' + data + '"');
        }
        
        csv.push(row.join(","));        
    }

    // Descargar archivo
    let csvFile = new Blob([csv.join("\n")], {type: "text/csv"});
    let downloadLink = document.createElement("a");
    downloadLink.download = "reporte_reservas_{{ date('Y-m-d') }}.csv";
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

// Auto-completar fechas para filtros rápidos
document.addEventListener('DOMContentLoaded', function() {
    const periodoSelect = document.querySelector('select[name="periodo"]');
    if (periodoSelect) {
        periodoSelect.addEventListener('change', function() {
            const hoy = new Date();
            const desde = document.getElementById('fechaDesde');
            const hasta = document.getElementById('fechaHasta');
            
            switch(this.value) {
                case 'hoy':
                    desde.value = hasta.value = hoy.toISOString().split('T')[0];
                    break;
                case '7':
                    const hace7Dias = new Date(hoy.getTime() - 7 * 24 * 60 * 60 * 1000);
                    desde.value = hace7Dias.toISOString().split('T')[0];
                    hasta.value = hoy.toISOString().split('T')[0];
                    break;
                case '15':
                    const hace15Dias = new Date(hoy.getTime() - 15 * 24 * 60 * 60 * 1000);
                    desde.value = hace15Dias.toISOString().split('T')[0];
                    hasta.value = hoy.toISOString().split('T')[0];
                    break;
                case '30':
                    const hace30Dias = new Date(hoy.getTime() - 30 * 24 * 60 * 60 * 1000);
                    desde.value = hace30Dias.toISOString().split('T')[0];
                    hasta.value = hoy.toISOString().split('T')[0];
                    break;
                case 'mes':
                    const primerDiaMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
                    const ultimoDiaMes = new Date(hoy.getFullYear(), hoy.getMonth() + 1, 0);
                    desde.value = primerDiaMes.toISOString().split('T')[0];
                    hasta.value = ultimoDiaMes.toISOString().split('T')[0];
                    break;
                case 'mes_pasado':
                    const primerDiaMesPasado = new Date(hoy.getFullYear(), hoy.getMonth() - 1, 1);
                    const ultimoDiaMesPasado = new Date(hoy.getFullYear(), hoy.getMonth(), 0);
                    desde.value = primerDiaMesPasado.toISOString().split('T')[0];
                    hasta.value = ultimoDiaMesPasado.toISOString().split('T')[0];
                    break;
            }
            
            // Auto-enviar el formulario cuando se cambia el periodo
            // document.getElementById('filterForm').submit();
        });
    }

    // Efectos visuales para las tarjetas clickeables
    const clickableCards = document.querySelectorAll('.clickable-card');
    
    clickableCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
            this.style.cursor = 'pointer';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
        
        card.addEventListener('mousedown', function() {
            this.style.transform = 'translateY(-2px) scale(0.98)';
        });
        
        card.addEventListener('mouseup', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
    });

    // Mostrar estado actual del filtro en consola para debug
    const estadoActual = document.getElementById('estadoFilter').value;
    console.log('Estado actual del filtro:', estadoActual);
});
</script>
@stop

@section('css')
<style>
.metric-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.metric-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    cursor: pointer;
}

.clickable-card {
    cursor: pointer;
}

.active-metric {
    border-color: #fff !important;
    box-shadow: 0 0 0 3px rgba(255,255,255,0.5) !important;
    transform: translateY(-3px);
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.075);
}

/* Mejoras para el modal */
.modal-content {
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    border-radius: 10px;
}

.modal-header {
    border-bottom: 2px solid #dee2e6;
    border-radius: 10px 10px 0 0 !important;
}

.modal-body .card {
    border: 1px solid #e3e6f0;
    border-radius: 8px;
}

.modal-body .card-header {
    background-color: #f8f9fc !important;
    border-bottom: 1px solid #e3e6f0;
    font-weight: 600;
}

.btn-close:focus {
    box-shadow: none;
}

/* Estilos para los badges de estado */
.badge.bg-warning { color: #000; }
.badge.bg-success { color: #fff; }
.badge.bg-danger { color: #fff; }
.badge.bg-dark { color: #fff; }
</style>
@endsection