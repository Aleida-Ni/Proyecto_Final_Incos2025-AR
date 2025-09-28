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
        <!-- FILTROS -->
        <form method="GET" class="row g-2 mb-3 align-items-end">
            <!-- Filtro rápido -->
            <div class="col-md-3">
                <label>Periodo rápido</label>
                <select name="periodo" class="form-control">
                    <option value="">-- Seleccionar --</option>
                    <option value="7"  {{ request('periodo') == '7' ? 'selected' : '' }}>Últimos 7 días</option>
                    <option value="15" {{ request('periodo') == '15' ? 'selected' : '' }}>Últimos 15 días</option>
                    <option value="30" {{ request('periodo') == '30' ? 'selected' : '' }}>Últimos 30 días</option>
                    <option value="mes" {{ request('periodo') == 'mes' ? 'selected' : '' }}>Este mes</option>
                    <option value="mes_pasado" {{ request('periodo') == 'mes_pasado' ? 'selected' : '' }}>Mes pasado</option>
                </select>
            </div>

            <!-- Rango personalizado -->
            <div class="col-md-2">
                <label>Desde</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>
            <div class="col-md-2">
                <label>Hasta</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>

            <!-- Cliente -->
            <div class="col-md-3">
                <label>Cliente (ID o nombre)</label>
                <input type="text" name="cliente" class="form-control" value="{{ request('cliente') }}">
            </div>

            <!-- Botones -->
            <div class="col-md-2">
                <button class="btn btn-primary"><i class="fas fa-filter"></i> Filtrar</button>
                <a href="{{ route('admin.reportes.ventas') }}" class="btn btn-secondary">
                    <i class="fas fa-undo"></i> Limpiar
                </a>
            </div>
        </form>

        <!-- TABLA -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ventas as $venta)
                        <tr>
                            <td>{{ $venta->id }}</td>
                            <td>{{ optional($venta->cliente)->nombre ?? optional($venta->cliente)->correo ?? '—' }}</td>
                            <td>{{ number_format($venta->total ?? 0, 2) }}</td>
                            <td>{{ optional($venta->creado_en)->format('d/m/Y H:i') ?? '' }}</td>
                            <td>
                                @if($venta->detalles)
                                    <ul class="mb-0">
                                        @foreach($venta->detalles as $d)
                                            <li>{{ $d->cantidad }} x {{ optional($d->producto)->nombre ?? 'Producto' }} ({{ number_format($d->precio, 2) }})</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No hay ventas</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
