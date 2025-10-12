@extends('adminlte::page')

@section('title', 'Detalle de Reserva')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Detalle de Reserva #{{ $reserva->id }}</h1>
    <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver al Listado
    </a>
</div>
@stop

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@php
    $cliente = $reserva->cliente;
    $totalReserva = $reserva->venta ? $reserva->venta->total : $reserva->servicios->sum('precio');
$metodoPago = $reserva->metodo_pago ?? ($reserva->venta->metodo_pago ?? null);
    $nombreCompleto = $cliente ? $cliente->nombre . ' ' . ($cliente->apellido_paterno ?? '') : 'N/A';
@endphp

<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Información de la Reserva</h4>
                </div>
                <div class="card-body">
                    <!-- Información principal -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Reserva #{{ $reserva->id }}</h5>
                            <p><strong>Cliente:</strong> {{ $nombreCompleto }}</p>
                            <p><strong>Teléfono:</strong> {{ $cliente->telefono ?? 'N/A' }}</p>
                            <p><strong>Email:</strong> {{ $cliente->correo ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</p>
                            <p><strong>Hora:</strong> {{ $reserva->hora }}</p>
                            <p><strong>Barbero:</strong> {{ $reserva->barbero->nombre ?? 'N/A' }}</p>
                            <p><strong>Estado:</strong> 
                                <span class="badge 
                                    @if($reserva->estado == 'pendiente') bg-warning
                                    @elseif($reserva->estado == 'realizada') bg-success 
                                    @elseif($reserva->estado == 'cancelada') bg-danger
                                    @elseif($reserva->estado == 'no_asistio') bg-dark
                                    @endif">
                                    {{ ucfirst($reserva->estado) }}
                                </span>
                            </p>
                            
                            @if($totalReserva > 0)
                            <p><strong>Total Pagado:</strong> 
                                <span class="fw-bold text-success">${{ number_format($totalReserva, 2) }}</span>
                            </p>
                            @endif
                            
                            @if($metodoPago)
                            <p><strong>Método de Pago:</strong> 
                                <span class="badge 
                                    @if($metodoPago == 'efectivo') bg-success
                                    @elseif($metodoPago == 'qr') bg-primary
                                    @elseif($metodoPago == 'transferencia') bg-info
                                    @else bg-secondary @endif">
                                    {{ ucfirst($metodoPago) }}
                                </span>
                            </p>
                            @else
                            <p><strong>Método de Pago:</strong> 
                                <span class="text-muted">No especificado</span>
                            </p>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <!-- Servicios realizados -->
                    @if($reserva->servicios->count() > 0)
                    <h6>Servicios Realizados</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Servicio</th>
                                    <th>Duración</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach($reserva->servicios as $servicioReserva)
                                <tr>
                                    <td>
                                        <strong>{{ $servicioReserva->servicio->nombre }}</strong>
                                        @if($servicioReserva->servicio->descripcion)
                                        <br><small class="text-muted">{{ $servicioReserva->servicio->descripcion }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $servicioReserva->servicio->duracion_minutos }} min</td>
                                    <td>${{ number_format($servicioReserva->precio, 2) }}</td>
                                </tr>
                                @php
                                    $total += $servicioReserva->precio;
                                @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2" class="text-end">Total:</th>
                                    <th>${{ number_format($total, 2) }}</th>
                                </tr>
                                @if($metodoPago)
                                <tr>
                                    <th colspan="2" class="text-end">Método de Pago:</th>
                                    <th>
                                        <span class="badge 
                                            @if($metodoPago == 'efectivo') bg-success
                                            @elseif($metodoPago == 'qr') bg-primary
                                            @elseif($metodoPago == 'transferencia') bg-info
                                            @else bg-secondary @endif">
                                            {{ ucfirst($metodoPago) }}
                                        </span>
                                    </th>
                                </tr>
                                @endif
                                @if($reserva->venta && $reserva->venta->created_at)
                                <tr>
                                    <th colspan="2" class="text-end">Fecha de Pago:</th>
                                    <th>{{ $reserva->venta->created_at->format('d/m/Y H:i') }}</th>
                                </tr>
                                @endif
                            </tfoot>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No se registraron servicios para esta reserva.
                    </div>
                    @endif

                    <!-- Observaciones -->
                    @if($reserva->observaciones)
                    <div class="mt-4">
                        <h6>Observaciones</h6>
                        <div class="card">
                            <div class="card-body">
                                {{ $reserva->observaciones }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Información de timestamps -->
                    <div class="row mt-4 text-muted small">
                        <div class="col-md-6">
                            <strong>Creado:</strong> {{ $reserva->creado_en->format('d/m/Y H:i') }}
                        </div>
                        @if($reserva->actualizado_en)
                        <div class="col-md-6 text-end">
                            <strong>Actualizado:</strong> {{ $reserva->actualizado_en->format('d/m/Y H:i') }}
                        </div>
                        @endif
                    </div>

                    <!-- Botones de acción -->
                    <div class="mt-4">
                        <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver al Listado
                        </a>
                        
                        @if($reserva->estado == 'pendiente')
                        <a href="{{ route('admin.reservas.completar', $reserva) }}" class="btn btn-success">
                            <i class="fas fa-check"></i> Completar Reserva
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}
.badge {
    font-size: 85%;
}
.table th {
    border-top: none;
    font-weight: 600;
}
</style>
@stop