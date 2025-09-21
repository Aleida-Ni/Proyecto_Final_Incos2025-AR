@extends('adminlte::page')

@section('title', 'Reportes - Ventas')

@section('content_header')
    <h1>Reporte de Ventas</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-auto">
                <label>Desde</label>
                <input type="date" name="from" class="form-control" value="{{ $from ?? '' }}">
            </div>
            <div class="col-auto">
                <label>Hasta</label>
                <input type="date" name="to" class="form-control" value="{{ $to ?? '' }}">
            </div>
            <div class="col-auto">
                <label>Cliente (ID)</label>
                <input type="text" name="cliente" class="form-control" value="{{ $cliente ?? '' }}" placeholder="ID del cliente (opcional)">
            </div>
            <div class="col-auto align-self-end">
                <button class="btn btn-primary">Filtrar</button>
                <a href="{{ route('admin.reportes.ventas') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead>
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
                                            <li>{{ $d->cantidad }} x {{ optional($d->producto)->nombre ?? 'Producto' }} ({{ number_format($d->precio,2) }})</li>
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
