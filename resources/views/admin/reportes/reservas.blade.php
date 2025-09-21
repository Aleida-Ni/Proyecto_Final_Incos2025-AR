@extends('adminlte::page')

@section('title', 'Reportes - Reservas')

@section('content_header')
    <h1>Reporte de Reservas</h1>
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
                <label>Estado</label>
                <select name="estado" class="form-control">
                    <option value="">Todos</option>
                    <option value="pendiente" {{ (isset($estado) && $estado=='pendiente')?'selected':'' }}>Pendiente</option>
                    <option value="realizada" {{ (isset($estado) && $estado=='realizada')?'selected':'' }}>Realizada</option>
                    <option value="cancelada" {{ (isset($estado) && $estado=='cancelada')?'selected':'' }}>Cancelada</option>
                </select>
            </div>
            <div class="col-auto align-self-end">
                <button class="btn btn-primary">Filtrar</button>
                <a href="{{ route('admin.reportes.reservas') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead>
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
                            <td>{{ ucfirst($r->estado) }}</td>
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
