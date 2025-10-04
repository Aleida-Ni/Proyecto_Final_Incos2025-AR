@extends('adminlte::page')

@section('title', 'Reportes - Ventas')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('content_header')
    <h1>Reporte de Ventas</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <!-- FILTROS MEJORADOS -->
        <form method="GET" class="row g-3 mb-4 align-items-end">
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

            <div class="col-md-2">
                <label class="form-label">Desde</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>
            
            <div class="col-md-2">
                <label class="form-label">Hasta</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">Empleado</label>
                <select name="empleado_id" class="form-select">
                    <option value="">Todos</option>
                    @foreach($empleados as $empleado)
                        <option value="{{ $empleado->id }}" {{ request('empleado_id') == $empleado->id ? 'selected' : '' }}>
                            {{ $empleado->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Método Pago</label>
                <select name="metodo_pago" class="form-select">
                    <option value="">Todos</option>
                    <option value="efectivo" {{ request('metodo_pago') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                    <option value="tarjeta" {{ request('metodo_pago') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                    <option value="transferencia" {{ request('metodo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
                <a href="{{ route('admin.reportes.ventas') }}" class="btn btn-outline-secondary w-100 mt-1">
                    <i class="fas fa-undo"></i> Limpiar
                </a>
            </div>
        </form>

        <!-- MÉTRICAS RÁPIDAS -->
        @if($ventas->count() > 0)
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h4 class="card-title">{{ $metricas['total_ventas'] }}</h4>
                        <p class="card-text">Total Ventas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h4 class="card-title">Bs. {{ number_format($metricas['ingreso_total'], 2) }}</h4>
                        <p class="card-text">Ingresos Totales</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h4 class="card-title">Bs. {{ number_format($metricas['venta_promedio'], 2) }}</h4>
                        <p class="card-text">Venta Promedio</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h4 class="card-title">Bs. {{ number_format($metricas['venta_maxima'], 2) }}</h4>
                        <p class="card-text">Venta Máxima</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- BOTONES DE EXPORTACIÓN -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Detalle de Ventas</h5>
            <div>
                <button class="btn btn-success btn-sm" onclick="exportToExcel()">
                    <i class="fas fa-file-excel"></i> Exportar Excel
                </button>
                <button class="btn btn-danger btn-sm" onclick="window.print()">
                    <i class="fas fa-print"></i> Imprimir
                </button>
            </div>
        </div>

        <!-- TABLA MEJORADA -->
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tabla-ventas">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Empleado</th>
                        <th>Método Pago</th>
                        <th class="text-end">Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ventas as $venta)
                        <tr>
                            <td>
                                <span class="badge bg-secondary">{{ $venta->codigo }}</span>
                            </td>
                            <td>{{ $venta->creado_en->format('d/m/Y H:i') }}</td>
                            <td>{{ $venta->cliente->nombre ?? 'Cliente no registrado' }}</td>
                            <td>{{ $venta->empleado->nombre ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ ucfirst($venta->metodo_pago) }}</span>
                            </td>
                            <td class="text-end fw-bold text-success">
                                Bs. {{ number_format($venta->total, 2) }}
                            </td>
                            <td>
                                <a href="{{ route('admin.ventas.show', $venta) }}" 
                                   class="btn btn-info btn-sm" 
                                   title="Ver detalle">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <p class="text-muted">No se encontraron ventas con los filtros aplicados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($ventas->count() > 0)
                <tfoot class="table-secondary">
                    <tr>
                        <th colspan="5" class="text-end">TOTAL GENERAL:</th>
                        <th class="text-end text-success">
                            Bs. {{ number_format($metricas['ingreso_total'], 2) }}
                        </th>
                        <th></th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>

        <!-- PAGINACIÓN FUNCIONAL -->
        @if($ventas->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Mostrando {{ $ventas->firstItem() }} - {{ $ventas->lastItem() }} de {{ $ventas->total() }} registros
            </div>
            {{ $ventas->links() }}
        </div>
        @endif
    </div>
</div>
@stop

@section('js')
<script>
function exportToExcel() {
    // Implementar exportación a Excel
    alert('Funcionalidad de exportación a Excel - Próximamente');
}

// Auto-selección de fechas para filtros rápidos
document.querySelector('select[name="periodo"]').addEventListener('change', function() {
    if (this.value === 'hoy') {
        const hoy = new Date().toISOString().split('T')[0];
        document.querySelector('input[name="from"]').value = hoy;
        document.querySelector('input[name="to"]').value = hoy;
    }
});
</script>
@stop