@extends('adminlte::page')

@section('title', 'Ticket de Reserva - Barbería Elite')

@section('content')
<div class="container mt-4">
    <div class="card ticket-card shadow-lg border-0 mx-auto" style="max-width: 500px;">
        <div class="card-header ticket-header text-center">
            <h3 class="mb-0">Barbería Elite</h3>
            <p class="mb-0 text-muted">Ticket de Reserva</p>
        </div>
        <div class="card-body">
            <div class="ticket-info">
                <div class="info-item">
                    <strong>Barbero:</strong>
                    <span>{{ $reserva->barbero->nombre }}</span>
                </div>
                
                @if($reserva->barbero->imagen)
                <div class="info-item text-center my-3">
                    <img src="{{ asset('storage/'.$reserva->barbero->imagen) }}" 
                         alt="Foto del barbero" 
                         class="barbero-img-ticket rounded">
                </div>
                @endif
                
                <div class="info-item">
                    <strong>Fecha:</strong>
                    <span>{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</span>
                </div>
                
                <div class="info-item">
                    <strong>Hora:</strong>
                    <span>{{ $reserva->hora }}</span>
                </div>
                
                <div class="info-item">
                    <strong>Cliente:</strong>
                    <span>{{ auth()->user()->nombre }} {{ auth()->user()->apellido_paterno }}</span>
                </div>
                
                <div class="info-item">
                    <strong>Estado:</strong>
                    <span class="badge bg-warning text-dark">Pendiente</span>
                </div>
            </div>

            <div class="ticket-footer text-center mt-4">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Por favor llega 5 minutos antes de tu cita programada.
                </div>
                
                <div class="d-grid gap-2">
                    <a href="{{ route('cliente.reservas') }}" class="btn btn-custom">
                        <i class="fas fa-arrow-left me-2"></i>Volver a Mis Reservas
                    </a>
                    <button onclick="window.print()" class="btn btn-outline-custom">
                        <i class="fas fa-print me-2"></i>Imprimir Ticket
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --color-blanco: #FFFFFF;
        --color-negro: #0b0b0b;
        --color-primario: #111827; /* acento oscuro */
        --color-fondo: #f8fafc;
        --color-gris-claro: #e6e9ee;
        --color-gris-medio: #6b7280;
    }

    body {
        background: var(--color-fondo) !important;
    }

    .ticket-card {
        border-radius: 12px;
        border: 1px solid var(--color-gris-claro);
        overflow: hidden;
        background: var(--color-blanco);
    }

    .ticket-header {
        background: transparent;
        color: var(--color-primario);
        border-bottom: 1px solid var(--color-gris-claro);
        padding: 16px;
    }

    .ticket-info {
        padding: 20px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid var(--color-beige-oscuro);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-item strong {
        color: var(--color-gris-oscuro);
        font-weight: 600;
    }

    .info-item span {
        color: var(--color-gris-medio);
        font-weight: 500;
    }

    .barbero-img-ticket {
        max-height: 140px;
        border: 1px solid var(--color-gris-claro);
        box-shadow: 0 6px 16px rgba(11,11,11,0.06);
    }

    .btn-custom {
        background: var(--color-primario);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 10px 18px;
        font-weight: 600;
        transition: all 0.18s ease;
    }

    .btn-custom:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 24px rgba(17,24,39,0.06);
    }

    .btn-outline-custom {
        border: 1px solid var(--color-gris-claro);
        color: var(--color-gris-medio);
        background: transparent;
        border-radius: 8px;
        padding: 10px 18px;
        font-weight: 600;
        transition: all 0.18s ease;
    }

    .btn-outline-custom:hover {
        background: var(--color-gris-claro);
        color: var(--color-negro);
    }

    @media print {
        .btn {
            display: none !important;
        }
        
        .ticket-card {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>
@endsection