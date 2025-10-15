@extends('adminlte::page')

@section('title', 'Reportes - Ventas')

@section('content_header')
    <h1>Reporte de Ventas</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
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
                    <option value="qr" {{ request('metodo_pago') == 'qr' ? 'selected' : '' }}>QR</option>
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


        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Detalle de Ventas</h5>
            <div>
                <a href="{{ route('admin.reportes.ventas.pdf') }}{{ Request::getQueryString() ? '?' . Request::getQueryString() : '' }}" 
                   class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>
        </div>

        <!-- TABLA MEJORADA -->
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tabla-ventas">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 80px">Código</th>
                        <th style="width: 120px">Fecha</th>
                        <th style="width: 150px">Empleado</th>
                        <th>Productos</th>
                        <th style="width: 100px">Método Pago</th>
                        <th style="width: 120px" class="text-end">Total</th>
                        <th style="width: 80px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ventas as $venta)
                        <tr>
                            <td>
                                <span class="badge bg-secondary">{{ $venta->codigo }}</span>
                            </td>
                            <td>{{ $venta->creado_en->format('d/m/Y H:i') }}</td>
                            <td>
                                <div>
                                    <strong>{{ $venta->empleado->nombre ?? 'N/A' }}</strong>
                                </div>
                                <small class="text-muted">
                                    {{ $venta->cliente->nombre ?? 'Cliente no registrado' }}
                                </small>
                            </td>
                            <td>
                                <div class="productos-lista">
                                    @foreach($venta->detalles as $detalle)
                                        <div class="producto-item mb-2 p-2 border rounded">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <span class="producto-nombre fw-bold">{{ $detalle->producto->nombre }}</span>
                                                    <div class="text-muted small">
                                                        Cantidad: {{ $detalle->cantidad }}
                                                    </div>
                                                </div>
                                                <div class="text-end ms-3">
                                                        <div class="text-success fw-bold">
                                                            {{-- Mostrar subtotal/total del detalle (fallback a subtotal si existe) --}}
                                                            Bs. {{ number_format($detalle->subtotal ?? $detalle->total ?? 0, 2) }}
                                                        </div>
                                                        <div class="text-muted small">
                                                            {{-- Preferir el precio registrado en la tabla productos, si existe. Si no, usar el precio del detalle o calcularlo desde subtotal/cantidad --}}
                                                            @php
                                                                $precioProducto = optional($detalle->producto)->precio ?? null;
                                                                $precioDetalle = $detalle->precio ?? null;
                                                                $precioCalculado = null;
                                                                if (empty($precioProducto)) {
                                                                    if ($precioDetalle) {
                                                                        $precioCalculado = $precioDetalle;
                                                                    } elseif (!empty($detalle->subtotal) && !empty($detalle->cantidad)) {
                                                                        $precioCalculado = $detalle->subtotal / max(1, $detalle->cantidad);
                                                                    }
                                                                }
                                                                $precioMostrar = $precioProducto ?? $precioCalculado ?? 0;
                                                            @endphp
                                                            Bs. {{ number_format($precioMostrar, 2) }} c/u
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
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

@section('css')
<style>
.productos-lista {
    max-height: 200px;
    overflow-y: auto;
}
.producto-item {
    border-left: 3px solid #0d6efd;
    background-color: #f8f9fa;
}
</style>
@stop

@section('js')
<script>
// Auto-selección de fechas para filtros rápidos (mantener esta funcionalidad)
document.querySelector('select[name="periodo"]').addEventListener('change', function() {
    const hoy = new Date();
    const desde = document.querySelector('input[name="from"]');
    const hasta = document.querySelector('input[name="to"]');
    
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
            desde.value = primerDiaMes.toISOString().split('T')[0];
            hasta.value = hoy.toISOString().split('T')[0];
            break;
        case 'mes_pasado':
            const primerDiaMesPasado = new Date(hoy.getFullYear(), hoy.getMonth() - 1, 1);
            const ultimoDiaMesPasado = new Date(hoy.getFullYear(), hoy.getMonth(), 0);
            desde.value = primerDiaMesPasado.toISOString().split('T')[0];
            hasta.value = ultimoDiaMesPasado.toISOString().split('T')[0];
            break;
    }
    
    // Auto-enviar el formulario
    this.form.submit();
});
</script>
@stop