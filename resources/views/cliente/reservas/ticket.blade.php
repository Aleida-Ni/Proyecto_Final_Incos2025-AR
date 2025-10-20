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
        --color-negro: #000000;
        --color-dorado: #D4AF37;
        --color-dorado-claro: #F4E4A8;
        --color-beige: #F5F5DC;
        --color-beige-oscuro: #E8E4D5;
        --color-gris-oscuro: #2C2C2C;
        --color-gris-medio: #4A4A4A;
    }

    body {
        background: linear-gradient(135deg, var(--color-beige) 0%, var(--color-blanco) 100%) !important;
    }

    .ticket-card {
        border-radius: 20px;
        border: 2px solid var(--color-dorado);
        overflow: hidden;
    }

    .ticket-header {
        background: linear-gradient(135deg, var(--color-negro) 0%, var(--color-gris-oscuro) 100%);
        color: var(--color-blanco);
        border-bottom: 3px solid var(--color-dorado);
        padding: 20px;
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
        max-height: 150px;
        border: 3px solid var(--color-dorado);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .btn-custom {
        background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
        color: var(--color-negro);
        border: none;
        border-radius: 10px;
        padding: 12px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.3);
    }

    .btn-outline-custom {
        border: 2px solid var(--color-dorado);
        color: var(--color-dorado);
        background: transparent;
        border-radius: 10px;
        padding: 12px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-custom:hover {
        background: var(--color-dorado);
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