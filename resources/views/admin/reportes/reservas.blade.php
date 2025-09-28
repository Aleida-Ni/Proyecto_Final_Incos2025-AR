@extends('adminlte::page')

@section('title', 'Reportes - Reservas')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('content_header')
    <h1>Reporte de Reservas</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <!-- FILTROS -->
        <form method="GET" class="row g-2 mb-3 align-items-end">
            <!-- Filtros rápidos -->
            <div class="col-md-3">
                <label>Periodo rápido</label>
                <select name="periodo" class="form-control">
                    <option value="">-- Seleccionar --</option>
                    <option value="7"  {{ request('periodo') == '7'  ? 'selected' : '' }}>Últimos 7 días</option>
                    <option value="15" {{ request('periodo') == '15' ? 'selected' : '' }}>Últimos 15 días</option>
                    <option value="30" {{ request('periodo') == '30' ? 'selected' : '' }}>Últimos 30 días</option>
                    <option value="mes" {{ request('periodo') == 'mes' ? 'selected' : '' }}>Este mes</option>
                    <option value="mes_pasado" {{ request('periodo') == 'mes_pasado' ? 'selected' : '' }}>Mes pasado</option>
                </select>
            </div>

            <!-- Filtro personalizado -->
            <div class="col-md-2">
                <label>Desde</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>
            <div class="col-md-2">
                <label>Hasta</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>

            <!-- Estado -->
            <div class="col-md-2">
                <label>Estado</label>
                <select name="estado" class="form-control">
                    <option value="">Todos</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="realizada" {{ request('estado') == 'realizada' ? 'selected' : '' }}>Realizada</option>
                    <option value="cancelada" {{ request('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="col-md-3">
                <button class="btn btn-primary"><i class="fas fa-filter"></i> Filtrar</button>
                <a href="{{ route('admin.reportes.reservas') }}" class="btn btn-secondary">
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
                        <th>Barbero</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Creado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservas as $r)
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>{{ optional($r->cliente)->nombre ?? (optional($r->cliente)->correo ?? 'Usuario') }}</td>
                            <td>{{ optional($r->barbero)->nombre ?? '—' }}</td>
                            <td>{{ \Carbon\Carbon::parse($r->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $r->hora }}</td>
                            <td>
                                <span class="badge 
                                    @if($r->estado=='pendiente') bg-warning 
                                    @elseif($r->estado=='realizada') bg-success 
                                    @elseif($r->estado=='cancelada') bg-danger 
                                    @endif">
                                    {{ ucfirst($r->estado) }}
                                </span>
                            </td>
                            <td>{{ optional($r->creado_en)->format('d/m/Y H:i') ?? '' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">No hay registros</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
