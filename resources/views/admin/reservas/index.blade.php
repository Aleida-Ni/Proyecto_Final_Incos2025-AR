@extends('adminlte::page')

@section('title', 'Gestión de Reservas')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('content_header')
    <h1>Gestión de Reservas</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
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
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        use Carbon\Carbon;
                        $now = Carbon::now();
                    @endphp

                    @forelse($reservas as $r)
                        @php
                            $fechaHoraReserva = Carbon::parse($r->fecha . ' ' . $r->hora);
                            $pasada = $fechaHoraReserva->lt($now);
                        @endphp
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>{{ optional($r->cliente)->nombre ?? 'Usuario' }}</td>
                            <td>{{ optional($r->barbero)->nombre ?? '—' }}</td>
                            <td>{{ Carbon::parse($r->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $r->hora }}</td>
                            <td>
                                <span class="badge 
                                    @if($r->estado=='pendiente') bg-warning 
                                    @elseif($r->estado=='realizada') bg-success 
                                    @elseif($r->estado=='cancelada') bg-danger
                                    @elseif($r->estado=='no_asistio') bg-dark
                                    @endif">
                                    {{ ucfirst($r->estado) }}
                                </span>

                                {{-- Mostrar aviso si la hora ya pasó --}}
                                @if($r->estado == 'pendiente' && $pasada)
                                    <span class="badge bg-secondary">Hora pasada</span>
                                @endif
                            </td>
                            <td>
                                @if($r->estado == 'pendiente')
                                    <form action="{{ route('admin.reservas.marcar', [$r->id, 'realizada']) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-success btn-sm">Marcar Realizada</button>
                                    </form>
                                    <form action="{{ route('admin.reservas.marcar', [$r->id, 'no_asistio']) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-dark btn-sm">No asistió</button>
                                    </form>
                                @else
                                    <em>—</em>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">No hay reservas</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
