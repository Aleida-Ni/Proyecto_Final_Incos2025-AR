@extends('adminlte::page')

@section('title', 'Reportes - Reservas')


@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Reporte de Reservas</h1>
        <div>
            <button class="btn btn-success btn-sm" onclick="exportToExcel()">
                <i class="fas fa-file-excel"></i> Exportar Excel
            </button>
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
        <form method="GET" class="row g-3 mb-4 align-items-end">
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

            <!-- Estado -->
            <div class="col-md-2">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select">
                    <option value="">Todos</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="realizada" {{ request('estado') == 'realizada' ? 'selected' : '' }}>Realizada</option>
                    <option value="cancelada" {{ request('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    <option value="no_asistio" {{ request('estado') == 'no_asistio' ? 'selected' : '' }}>No Asistió</option>
                </select>
            </div>

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

        <!-- MÉTRICAS Y ESTADÍSTICAS -->
        @if(isset($estadisticas) && $reservas->count() > 0)
        <div class="row mb-4">
            <div class="col-md-2">
                <div class="card metric-card bg-primary text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['total'] }}</h3>
                        <p class="card-text mb-0">Total Reservas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card metric-card bg-warning text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['pendientes'] }}</h3>
                        <p class="card-text mb-0">Pendientes</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card metric-card bg-success text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['realizadas'] }}</h3>
                        <p class="card-text mb-0">Realizadas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card metric-card bg-danger text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['canceladas'] }}</h3>
                        <p class="card-text mb-0">Canceladas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card metric-card bg-dark text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['no_asistio'] }}</h3>
                        <p class="card-text mb-0">No Asistió</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card metric-card bg-info text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['tasa_asistencia'] }}%</h3>
                        <p class="card-text mb-0">Tasa Asistencia</p>
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
                        <th width="150">Creado</th>
                        <th width="100" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservas as $r)
                        @php
                            $fechaReserva = \Carbon\Carbon::parse($r->fecha);
                            $esPasada = $fechaReserva->lt(\Carbon\Carbon::today());
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
                                <small>{{ optional($r->creado_en)->format('d/m/Y H:i') ?? 'N/A' }}</small>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-info btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalDetalle{{ $r->id }}"
                                        title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if($r->estado == 'pendiente')
                                    <form action="{{ route('admin.reservas.marcar', [$r->id, 'realizada']) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('¿Marcar como realizada?')">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" title="Marcar realizada">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
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
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0"><i class="fas fa-user me-2"></i>Información del Cliente</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <strong class="text-primary">Nombre:</strong><br>
                                    <span class="fs-6">{{ $r->cliente->nombre ?? 'Cliente no registrado' }}</span>
                                </div>
                                @if($r->cliente && $r->cliente->telefono)
                                <div class="mb-2">
                                    <strong class="text-primary">Teléfono:</strong><br>
                                    <span class="fs-6">
                                        <i class="fas fa-phone text-success me-1"></i>
                                        {{ $r->cliente->telefono }}
                                    </span>
                                </div>
                                @endif
                                @if($r->cliente && $r->cliente->correo)
                                <div class="mb-2">
                                    <strong class="text-primary">Email:</strong><br>
                                    <span class="fs-6">
                                        <i class="fas fa-envelope text-info me-1"></i>
                                        {{ $r->cliente->correo }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0"><i class="fas fa-cut me-2"></i>Información del Servicio</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <strong class="text-primary">Barbero:</strong><br>
                                    <span class="fs-6 badge bg-secondary">{{ $r->barbero->nombre ?? 'No asignado' }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong class="text-primary">Fecha:</strong><br>
                                    <span class="fs-6">
                                        <i class="fas fa-calendar text-warning me-1"></i>
                                        {{ \Carbon\Carbon::parse($r->fecha)->format('d/m/Y') }}
                                    </span>
                                </div>
                                <div class="mb-2">
                                    <strong class="text-primary">Hora:</strong><br>
                                    <span class="fs-6">
                                        <i class="fas fa-clock text-success me-1"></i>
                                        {{ $r->hora }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Estado de la Reserva</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <strong class="text-primary">Estado Actual:</strong><br>
                                            <span class="badge fs-6 
                                                @if($r->estado=='pendiente') bg-warning 
                                                @elseif($r->estado=='realizada') bg-success 
                                                @elseif($r->estado=='cancelada') bg-danger
                                                @elseif($r->estado=='no_asistio') bg-dark
                                                @endif">
                                                {{ ucfirst($r->estado) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <strong class="text-primary">Fecha de Creación:</strong><br>
                                            <span class="fs-6">
                                                <i class="fas fa-calendar-plus text-info me-1"></i>
                                                {{ $r->creado_en->format('d/m/Y H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($r->estado == 'pendiente')
                                    @php
                                        $fechaReserva = \Carbon\Carbon::parse($r->fecha . ' ' . $r->hora);
                                        $esPasada = $fechaReserva->lt(\Carbon\Carbon::now());
                                    @endphp
                                    @if($esPasada)
                                        <div class="alert alert-warning mt-2 mb-0">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <strong>¡Atención!</strong> Esta reserva está pendiente pero la hora ya pasó.
                                        </div>
                                    @else
                                        <div class="alert alert-info mt-2 mb-0">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Reserva pendiente para el 
                                            {{ \Carbon\Carbon::parse($r->fecha)->locale('es')->dayName }} 
                                            {{ \Carbon\Carbon::parse($r->fecha)->format('d/m/Y') }} 
                                            a las {{ $r->hora }}
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if($r->estado == 'pendiente')
                <div class="me-auto">
                    <form action="{{ route('admin.reservas.marcar', [$r->id, 'realizada']) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm" 
                                onclick="return confirm('¿Confirmar que el cliente asistió a su cita?')">
                            <i class="fas fa-check me-1"></i>Marcar como Realizada
                        </button>
                    </form>
                    <form action="{{ route('admin.reservas.marcar', [$r->id, 'no_asistio']) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-dark btn-sm" 
                                onclick="return confirm('¿Marcar que el cliente no asistió?')">
                            <i class="fas fa-times me-1"></i>No Asistió
                        </button>
                    </form>
                </div>
                @endif
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
function exportToExcel() {
    // Simulación de exportación a Excel
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
document.querySelector('select[name="periodo"]').addEventListener('change', function() {
    const hoy = new Date();
    const desde = document.getElementById('fechaDesde');
    const hasta = document.getElementById('fechaHasta');
    
    switch(this.value) {
        case 'hoy':
            desde.value = hasta.value = hoy.toISOString().split('T')[0];
            break;
        case '7':
            desde.value = new Date(hoy.getTime() - 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
            hasta.value = hoy.toISOString().split('T')[0];
            break;
        case 'mes':
            const primerDiaMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
            const ultimoDiaMes = new Date(hoy.getFullYear(), hoy.getMonth() + 1, 0);
            desde.value = primerDiaMes.toISOString().split('T')[0];
            hasta.value = ultimoDiaMes.toISOString().split('T')[0];
            break;
    }
});
</script>
@stop
@section('css')
    <style>
        .metric-card {
            transition: transform 0.2s;
        }
        .metric-card:hover {
            transform: translateY(-5px);
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
        .modal-body {
            font-size: 14px;
            line-height: 1.5;
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
        .modal-body strong {
            color: #2e59d9;
            font-size: 13px;
        }
        .modal-body .fs-6 {
            font-size: 14px !important;
            color: #5a5c69;
        }
        .btn-close:focus {
            box-shadow: none;
        }
    </style>
@endsection