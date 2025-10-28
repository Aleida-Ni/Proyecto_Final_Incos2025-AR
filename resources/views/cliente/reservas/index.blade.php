@extends('cliente.layout')

@section('title', 'Mis Reservas - Barbería Elite')

@section('content')
<div class="container my-5">
    <!-- Encabezado elegante -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-gris-oscuro mb-3">Mis Reservas</h1>
        <p class="text-gris-medio fs-5">Gestiona y revisa todas tus citas programadas</p>
    </div>

    <!-- Tabla de reservas -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dorado text-negro py-3">
            <h4 class="mb-0 fw-bold">
                <i class="fas fa-calendar-alt me-2"></i>Historial de Reservas
            </h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">
                                <i class="fas fa-calendar me-2"></i>Fecha
                            </th>
                            <th>
                                <i class="fas fa-clock me-2"></i>Hora
                            </th>
                            <th>
                                <i class="fas fa-user me-2"></i>Barbero
                            </th>
                            <th>
                                <i class="fas fa-tag me-2"></i>Estado
                            </th>
                            <th class="text-center pe-4">
                                <i class="fas fa-cogs me-2"></i>Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservas as $reserva)
                        <tr class="align-middle">
                            <td class="ps-4">
                                <div class="fw-bold text-gris-oscuro">
                                    {{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}
                                </div>
                                <small class="text-gris-medio">
                                    {{ \Carbon\Carbon::parse($reserva->fecha)->locale('es')->dayName }}
                                </small>
                            </td>
                            <td>
                                <span class="fw-bold text-gris-oscuro">{{ $reserva->hora }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($reserva->barbero->imagen)
                                    <img src="{{ asset('storage/' . $reserva->barbero->imagen) }}" 
                                         alt="{{ $reserva->barbero->nombre }}"
                                         class="rounded-circle me-3"
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                    <div class="rounded-circle bg-beige d-flex align-items-center justify-content-center me-3"
                                         style="width: 40px; height: 40px;">
                                        <i class="fas fa-user text-gris-medio"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-gris-oscuro">{{ $reserva->barbero->nombre }}</div>
                                        <small class="text-gris-medio">{{ $reserva->barbero->cargo ?? 'Barbero' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $badgeClass = 'bg-secondary';
                                    $badgeIcon = 'fas fa-question';
                                    switch($reserva->estado) {
                                        case 'pendiente': 
                                            $badgeClass = 'bg-warning text-dark'; 
                                            $badgeIcon = 'fas fa-clock';
                                            break;
                                        case 'confirmada': 
                                            $badgeClass = 'bg-info text-white'; 
                                            $badgeIcon = 'fas fa-check-circle';
                                            break;
                                        case 'realizada': 
                                            $badgeClass = 'bg-success'; 
                                            $badgeIcon = 'fas fa-calendar-check';
                                            break;
                                        case 'no_asistio': 
                                            $badgeClass = 'bg-dark'; 
                                            $badgeIcon = 'fas fa-user-times';
                                            break;
                                        case 'cancelada': 
                                            $badgeClass = 'bg-danger'; 
                                            $badgeIcon = 'fas fa-ban';
                                            break;
                                    }
                                @endphp
                                <span class="badge estado-badge {{ $badgeClass }}">
                                    <i class="{{ $badgeIcon }} me-1"></i>
                                    {{ ucfirst(str_replace('_', ' ', $reserva->estado)) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info btn-action" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#ticketModal{{ $reserva->id }}"
                                            title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($reserva->estado == 'pendiente')
                                    <button class="btn btn-danger btn-action ms-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalCancelar{{ $reserva->id }}"
                                            title="Cancelar reserva">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Ticket -->
                        <!-- Modal Ticket -->
<div class="modal fade" id="ticketModal{{ $reserva->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content ticket-modal-content">
            <div class="modal-body p-0">
                <div class="ticket-container">
                    <!-- Encabezado del ticket -->
                    <div class="ticket-header text-center py-3">
                        <h4 class="mb-1 fw-bold">BARBERÍA ELITE</h4>
                        <p class="mb-0 small">Tu estilo, nuestra pasión</p>
                        <div class="ticket-divider my-2"></div>
                    </div>
                    
                    <!-- Información de la reserva -->
                    <div class="ticket-body px-3 py-2">
                        <div class="ticket-row mb-2">
                            <span class="ticket-label">RESERVA #</span>
                            <span class="ticket-value">{{ str_pad($reserva->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        
                        <div class="ticket-row mb-2">
                            <span class="ticket-label">CLIENTE</span>
                            <span class="ticket-value">{{ Auth::user()->name ?? 'Cliente' }}</span>
                        </div>
                        
                        <div class="ticket-divider-light my-2"></div>
                        
                        <div class="ticket-row mb-2">
                            <span class="ticket-label">BARBERO</span>
                            <span class="ticket-value">{{ $reserva->barbero->nombre }}</span>
                        </div>
                        
                        <div class="ticket-row mb-2">
                            <span class="ticket-label">FECHA</span>
                            <span class="ticket-value">{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</span>
                        </div>
                        
                        <div class="ticket-row mb-2">
                            <span class="ticket-label">HORA</span>
                            <span class="ticket-value">{{ $reserva->hora }}</span>
                        </div>
                        
                        <div class="ticket-divider-light my-2"></div>
                        
                        <div class="ticket-row mb-2">
                            <span class="ticket-label">ESTADO</span>
                            <span class="ticket-value">
                                <span class="badge {{ $badgeClass }} ticket-badge">
                                    {{ ucfirst(str_replace('_', ' ', $reserva->estado)) }}
                                </span>
                            </span>
                        </div>
                        
                            @if($reserva->servicios && count($reserva->servicios) > 0)
                        <div class="ticket-divider-light my-2"></div>
                        
                        <div class="ticket-services">
                            <div class="ticket-label mb-1">SERVICIOS</div>
                            @foreach($reserva->servicios as $servicioReserva)
                            <div class="ticket-service-item">
                                <span class="service-name">{{ optional($servicioReserva->servicio)->nombre ?? 'Servicio' }}</span>
                                <span class="service-price">Bs {{ number_format($servicioReserva->precio ?? optional($servicioReserva->servicio)->precio ?? 0, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                            
                            <div class="ticket-total mt-2 pt-2">
                                <span class="ticket-label">TOTAL</span>
                                <span class="ticket-value">Bs {{ number_format($reserva->servicios->sum('precio'), 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Pie del ticket -->
                    <div class="ticket-footer text-center py-3">
                        <div class="ticket-divider mb-2"></div>
                        <p class="mb-1 small">¡Gracias por tu preferencia!</p>
                        <p class="mb-0 small text-muted">{{ now()->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
<div class="modal-footer justify-content-center py-3">
    <button type="button" class="btn btn-outline-secondary btn-sm me-2" data-bs-dismiss="modal">
        <i class="fas fa-times me-1"></i>Cerrar
    </button>
    <button type="button" class="btn btn-primary btn-sm" onclick="descargarTicket({{ $reserva->id }})">
        <i class="fas fa-download me-1"></i>Descargar Ticket
    </button>
</div>
        </div>
    </div>
</div>

                        <!-- Modal Cancelar -->
                        <div class="modal fade" id="modalCancelar{{ $reserva->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content custom-modal">
                                    <div class="modal-header custom-modal-header bg-danger">
                                        <h5 class="modal-title text-white">
                                            <i class="fas fa-exclamation-triangle me-2"></i>Cancelar Reserva
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-warning mb-0">
                                            <i class="fas fa-info-circle me-2"></i>
                                            ¿Estás seguro que deseas cancelar la reserva para 
                                            <strong>{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }} {{ $reserva->hora }}</strong> 
                                            con <strong>{{ $reserva->barbero->nombre }}</strong>?
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">
                                            <i class="fas fa-arrow-left me-1"></i>Mantener Reserva
                                        </button>
                                        <form method="POST" action="{{ route('cliente.reservas.cancelar', $reserva->id) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-ban me-1"></i>Sí, Cancelar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-calendar-times fa-4x text-beige-oscuro mb-4"></i>
                                    <h4 class="text-gris-medio mb-3">No tienes reservas</h4>
                                    <p class="text-gris-medio mb-4">Programa tu primera cita con nuestros barberos expertos.</p>
                                    <a href="{{ route('cliente.barberos.index') }}" class="btn btn-custom">
                                        <i class="fas fa-calendar-plus me-2"></i>Reservar Ahora
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Variables CSS */
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

    /* Encabezado */
    h1 {
        background: linear-gradient(135deg, var(--color-gris-oscuro) 0%, var(--color-dorado) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 2.8rem;
        font-weight: 700;
    }

    /* Card principal */
    .card {
        border-radius: 20px;
        overflow: hidden;
    }

    .bg-dorado {
        background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%) !important;
    }

    .text-negro {
        color: var(--color-negro) !important;
    }

    /* Tabla */
    .table {
        margin-bottom: 0;
    }

    .table th {
        border-bottom: 2px solid var(--color-dorado);
        font-weight: 600;
        padding: 1rem;
    }

    .table td {
        padding: 1rem;
        vertical-align: middle;
        border-color: var(--color-beige-oscuro);
    }

    .table tbody tr:hover {
        background-color: rgba(212, 175, 55, 0.05);
    }

    /* Badges de estado */
    .estado-badge {
        padding: 8px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    /* Botones de acción */
    .btn-action {
        border-radius: 8px;
        padding: 6px 10px;
        transition: all 0.3s ease;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    /* Modales */
    .custom-modal {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .custom-modal-header {
        border-radius: 15px 15px 0 0;
        border-bottom: 2px solid rgba(255,255,255,0.2);
    }

    .ticket-content {
        background: var(--color-blanco);
        border-radius: 10px;
        padding: 20px;
    }

    .reserva-info {
        border-left: 4px solid var(--color-dorado);
    }

    /* Estado vacío */
    .empty-state {
        padding: 3rem 1rem;
    }

    /* Botón personalizado */
    .btn-custom {
        background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
        color: var(--color-negro);
        border: none;
        border-radius: 25px;
        padding: 12px 25px;
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
        border-radius: 25px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-custom:hover {
        background: var(--color-dorado);
        color: var(--color-negro);
    }

    /* Responsive */
    @media (max-width: 768px) {
        h1 {
            font-size: 2.2rem;
        }
        
        .table-responsive {
            font-size: 0.9rem;
        }
        
        .btn-group .btn {
            padding: 4px 8px;
        }
    }
    /* Estilos específicos para el ticket */
/* Mejoras para el ticket para que se vea mejor en imagen */
.ticket-container {
    background: white;
    font-family: 'Courier New', monospace, sans-serif;
    max-width: 300px;
    margin: 0 auto;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.ticket-header {
    background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
    color: var(--color-negro);
    padding: 15px 10px;
}

.ticket-body {
    background: white;
    padding: 15px 10px;
}

.ticket-footer {
    background: #f8f9fa;
    border-top: 2px dashed #dee2e6;
    padding: 15px 10px;
}

.ticket-divider {
    height: 3px;
    background: var(--color-negro);
    width: 85%;
    margin: 12px auto;
    border: none;
}

.ticket-divider-light {
    height: 1px;
    background: #e0e0e0;
    width: 100%;
    margin: 10px 0;
    border: none;
}

.ticket-row {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    line-height: 1.4;
    margin-bottom: 8px;
}

.ticket-label {
    font-weight: bold;
    color: var(--color-gris-oscuro);
    text-transform: uppercase;
    font-size: 12px;
}

.ticket-value {
    color: var(--color-gris-medio);
    text-align: right;
    font-weight: 500;
}

.ticket-badge {
    font-size: 10px;
    padding: 4px 8px;
    border-radius: 12px;
}

.ticket-services {
    font-size: 13px;
    margin-top: 10px;
}

.ticket-service-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 6px;
    padding-bottom: 4px;
    border-bottom: 1px dotted #f0f0f0;
}

.service-name {
    flex: 1;
    color: var(--color-gris-medio);
}

.service-price {
    font-weight: bold;
    color: var(--color-gris-oscuro);
}

.ticket-total {
    border-top: 2px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    font-weight: bold;
    padding-top: 8px;
    margin-top: 8px;
    font-size: 15px;
}

/* Mejorar la calidad de la imagen generada */
.ticket-modal-content {
    border: none;
    border-radius: 12px;
    overflow: hidden;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
// Función para descargar el ticket como imagen
async function descargarTicket(reservaId) {
    try {
        const ticketElement = document.querySelector('#ticketModal' + reservaId + ' .ticket-container');
        
        // Mostrar mensaje de carga
        const downloadBtn = document.querySelector('#ticketModal' + reservaId + ' .btn-primary');
        const originalText = downloadBtn.innerHTML;
        downloadBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Generando...';
        downloadBtn.disabled = true;

        // Crear canvas con html2canvas
        const canvas = await html2canvas(ticketElement, {
            scale: 3, // Alta resolución
            backgroundColor: '#ffffff',
            useCORS: true,
            logging: false,
            width: ticketElement.scrollWidth,
            height: ticketElement.scrollHeight
        });

        // Convertir canvas a imagen
        const imagen = canvas.toDataURL('image/png', 1.0);
        
        // Crear enlace de descarga
        const enlace = document.createElement('a');
        enlace.download = `ticket-reserva-${reservaId}.png`;
        enlace.href = imagen;
        
        // Simular click para descargar
        document.body.appendChild(enlace);
        enlace.click();
        document.body.removeChild(enlace);

        // Restaurar botón
        downloadBtn.innerHTML = originalText;
        downloadBtn.disabled = false;

    } catch (error) {
        console.error('Error al generar el ticket:', error);
        alert('Error al generar el ticket. Inténtalo de nuevo.');
        
        // Restaurar botón en caso de error
        const downloadBtn = document.querySelector('#ticketModal' + reservaId + ' .btn-primary');
        downloadBtn.innerHTML = '<i class="fas fa-download me-1"></i>Descargar';
        downloadBtn.disabled = false;
    }
}

// Versión alternativa que también permite imprimir
function descargarOImprimirTicket(reservaId, accion = 'descargar') {
    if (accion === 'descargar') {
        descargarTicket(reservaId);
    } else {
        imprimirTicket(reservaId);
    }
}

// Función de impresión (mantener como respaldo)
function imprimirTicket(reservaId) {
    const ticketElement = document.querySelector('#ticketModal' + reservaId + ' .ticket-container');
    const printWindow = window.open('', '_blank');
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Ticket Reserva #${reservaId}</title>
            <style>
                body { 
                    font-family: 'Courier New', monospace; 
                    margin: 0; 
                    padding: 20px; 
                    background: white;
                    display: flex;
                    justify-content: center;
                }
                .ticket-container {
                    max-width: 300px;
                    border: 1px solid #ddd;
                    background: white;
                }
                .ticket-header {
                    background: #D4AF37 !important;
                    color: black !important;
                    text-align: center;
                    padding: 15px 10px;
                }
                .ticket-body { padding: 10px; }
                .ticket-footer {
                    background: #f8f9fa;
                    text-align: center;
                    padding: 10px;
                    border-top: 1px dashed #ddd;
                }
                .ticket-divider {
                    height: 2px;
                    background: black;
                    width: 80%;
                    margin: 10px auto;
                }
                .ticket-divider-light {
                    height: 1px;
                    background: #ddd;
                    margin: 8px 0;
                }
                .ticket-row {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 5px;
                    font-size: 14px;
                }
                .ticket-label { font-weight: bold; }
                .badge {
                    padding: 3px 8px;
                    border-radius: 4px;
                    font-size: 12px;
                }
                @media print {
                    body { margin: 0; padding: 0; }
                    .ticket-container { border: none !important; }
                }
            </style>
        </head>
        <body>
            ${ticketElement.outerHTML}
        </body>
        </html>
    `);
    
    printWindow.document.close();
    printWindow.onload = function() {
        printWindow.print();
    };
}
</script>
@endsection