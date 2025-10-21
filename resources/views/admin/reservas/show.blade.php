@extends('adminlte::page')
@section('title', 'Detalle de Reserva')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <!-- Ticket estilo Receiptify mejorado -->
            <div class="receiptify-ticket" id="ticketToDownload">
                <div class="receipt-header">
                    <h1>BARBERÍA ELITE</h1>
                    <div class="receipt-subtitle">Tu estilo, nuestra pasión</div>
                </div>
                
                <div class="receipt-section">
                    <div class="receipt-title">RESERVA #{{ str_pad($reserva->id, 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="receipt-info">
                        <div class="info-row">
                            <span>CLIENTE</span>
                            <span>{{ $reserva->cliente ? $reserva->cliente->nombre . ' ' . ($reserva->cliente->apellido_paterno ?? '') : 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span>BARBERO</span>
                            <span>{{ $reserva->barbero->nombre ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span>FECHA</span>
                            <span>{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-row">
                            <span>HORA</span>
                            <span>{{ $reserva->hora }}</span>
                        </div>
                        <div class="info-row">
                            <span>ESTADO</span>
                            <span class="status-{{ $reserva->estado }}">{{ strtoupper($reserva->estado) }}</span>
                        </div>
                    </div>
                </div>

                @php
                    $totalReserva = $reserva->venta ? $reserva->venta->total : $reserva->servicios->sum(function($servicio) {
                        return $servicio->pivot->precio ?? $servicio->precio;
                    });
                    $metodoPago = $reserva->metodo_pago ?? ($reserva->venta->metodo_pago ?? null);
                @endphp

                @if($reserva->servicios->count() > 0)
                <div class="receipt-section">
                    <div class="receipt-title">SERVICIOS CONTRATADOS</div>
                    <div class="services-table">
                        <div class="table-header">
                            <span>QTY</span>
                            <span>SERVICIO</span>
                            <span>PRECIO</span>
                        </div>
                        @php
                            $total = 0;
                            $counter = 0;
                        @endphp
                        @foreach($reserva->servicios as $servicio)
                        <div class="table-row">
                            <span>{{ str_pad($counter, 2, '0', STR_PAD_LEFT) }}</span>
                            <span>{{ strtoupper($servicio->nombre) }}</span>
                            <span>${{ number_format($servicio->pivot->precio ?? $servicio->precio, 2) }}</span>
                        </div>
                        @php
                            $total += $servicio->pivot->precio ?? $servicio->precio;
                            $counter++;
                        @endphp
                        @endforeach
                    </div>
                </div>

                <div class="receipt-section">
                    <div class="summary">
                        <div class="summary-row">
                            <span>SERVICIOS:</span>
                            <span>{{ $reserva->servicios->count() }}</span>
                        </div>
                        <div class="summary-row total">
                            <span>TOTAL:</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        @if($metodoPago)
                        <div class="summary-row">
                            <span>MÉTODO PAGO:</span>
                            <span>{{ strtoupper($metodoPago) }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @else
                <div class="receipt-section">
                    <div class="no-services">
                        <em>NO SE REGISTRARON SERVICIOS</em>
                    </div>
                </div>
                @endif

                @if($reserva->observaciones)
                <div class="receipt-section">
                    <div class="receipt-title">OBSERVACIONES</div>
                    <div class="observations">
                        {{ strtoupper($reserva->observaciones) }}
                    </div>
                </div>
                @endif

                <div class="receipt-section">
                    <div class="timestamps">
                        <div class="timestamp-row">
                            <span>CREADO:</span>
                            <span>{{ $reserva->creado_en->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($reserva->actualizado_en)
                        <div class="timestamp-row">
                            <span>ACTUALIZADO:</span>
                            <span>{{ $reserva->actualizado_en->format('d/m/Y H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="receipt-footer">
                    <div class="thank-you">¡GRACIAS POR SU VISITA!</div>
                    <div class="website">barberiaelite.com</div>
                    <div class="timestamp">{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }} {{ $reserva->hora }}</div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="action-buttons mt-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="{{ route('admin.reservas.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left me-2"></i>Volver
                        </a>
                    </div>
                    <div class="col-md-4">
                        <button id="download-ticket" class="btn btn-outline-primary w-100">
                            <i class="fas fa-download me-2"></i>Descargar
                        </a>
                    </div>
                    <div class="col-md-4">
                        <button id="share-ticket" class="btn btn-outline-success w-100">
                            <i class="fas fa-share-alt me-2"></i>Compartir
                        </button>
                    </div>
                </div>
                
                @if($reserva->estado == 'pendiente')
                <div class="row mt-3">
                    <div class="col-12">
                        <a href="{{ route('admin.reservas.completar', $reserva) }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-check me-2"></i>Completar Reserva
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
:root {
    --color-negro: #000000;
    --color-blanco: #FFFFFF;
    --color-gris-oscuro: #2C2C2C;
    --color-gris-medio: #4A4A4A;
    --color-dorado: #D4AF37;
}

/* Estilo Receiptify mejorado */
.receiptify-ticket {
    background: var(--color-blanco);
    border: 2px solid var(--color-negro);
    border-radius: 0;
    padding: 2rem;
    font-family: 'Courier New', 'Monaco', 'Menlo', monospace;
    max-width: 400px;
    margin: 0 auto;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    line-height: 1.2;
}

.receipt-header {
    text-align: center;
    border-bottom: 2px dashed var(--color-negro);
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
}

.receipt-header h1 {
    font-weight: 900;
    font-size: 1.8rem;
    margin: 0 0 0.5rem 0;
    color: var(--color-negro);
    letter-spacing: 2px;
    text-transform: uppercase;
}

.receipt-subtitle {
    font-size: 0.9rem;
    color: var(--color-gris-medio);
    font-style: italic;
    letter-spacing: 1px;
}

.receipt-section {
    margin-bottom: 1.5rem;
}

.receipt-title {
    font-weight: 700;
    font-size: 0.9rem;
    text-transform: uppercase;
    margin-bottom: 0.75rem;
    color: var(--color-negro);
    border-bottom: 1px solid var(--color-negro);
    padding-bottom: 0.25rem;
    letter-spacing: 1px;
}

.receipt-info {
    font-size: 0.85rem;
}

.info-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.4rem;
    letter-spacing: 0.5px;
}

.info-row span:first-child {
    font-weight: 700;
    text-transform: uppercase;
}

.info-row span:last-child {
    text-align: right;
    font-weight: 600;
}

.status-pendiente {
    color: #ff6b00;
    font-weight: 700;
}

.status-realizada {
    color: #00a650;
    font-weight: 700;
}

.status-cancelada {
    color: #ff0000;
    font-weight: 700;
}

.status-no_asistio {
    color: #666666;
    font-weight: 700;
}

.services-table {
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}

.table-header, .table-row {
    display: grid;
    grid-template-columns: 0.5fr 2fr 1fr;
    gap: 0.5rem;
    padding: 0.3rem 0;
}

.table-header {
    font-weight: 700;
    border-bottom: 1px solid var(--color-negro);
    margin-bottom: 0.5rem;
    text-transform: uppercase;
}

.table-row {
    border-bottom: 1px dashed #ccc;
}

.table-row:last-child {
    border-bottom: none;
}

.table-row span:nth-child(2) {
    text-transform: uppercase;
    font-weight: 600;
}

.table-row span:last-child {
    text-align: right;
    font-weight: 600;
}

.summary {
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.4rem;
}

.summary-row.total {
    font-weight: 700;
    font-size: 0.9rem;
    border-top: 1px solid var(--color-negro);
    padding-top: 0.5rem;
    margin-top: 0.5rem;
}

.summary-row span:first-child {
    font-weight: 700;
    text-transform: uppercase;
}

.summary-row span:last-child {
    font-weight: 600;
}

.no-services {
    text-align: center;
    font-style: italic;
    color: var(--color-gris-medio);
    font-size: 0.8rem;
    text-transform: uppercase;
}

.observations {
    background: #f8f8f8;
    padding: 0.75rem;
    border-radius: 2px;
    border-left: 3px solid var(--color-dorado);
    font-style: italic;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.timestamps {
    font-size: 0.75rem;
    color: var(--color-gris-medio);
}

.timestamp-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.3rem;
}

.timestamp-row span:first-child {
    font-weight: 600;
    text-transform: uppercase;
}

.receipt-footer {
    text-align: center;
    border-top: 2px dashed var(--color-negro);
    padding-top: 1rem;
    margin-top: 1.5rem;
}

.thank-you {
    font-weight: 700;
    font-size: 0.9rem;
    margin: 0 0 0.5rem 0;
    color: var(--color-negro);
    letter-spacing: 1px;
    text-transform: uppercase;
}

.website {
    font-size: 0.8rem;
    color: var(--color-gris-medio);
    margin: 0 0 0.25rem 0;
    letter-spacing: 0.5px;
}

.timestamp {
    font-size: 0.75rem;
    color: var(--color-gris-medio);
    margin: 0;
    letter-spacing: 0.5px;
}

.action-buttons .btn {
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.action-buttons .btn:hover {
    transform: translateY(-2px);
}

.btn-outline-primary:hover {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.btn-outline-success:hover {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
}

.btn-outline-warning:hover {
    background-color: #ffc107;
    border-color: #ffc107;
    color: black;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
}

/* Responsive */
@media (max-width: 576px) {
    .receiptify-ticket {
        padding: 1.5rem;
        margin: 0 1rem;
    }
    
    .receipt-header h1 {
        font-size: 1.5rem;
    }
    
    .table-header, .table-row {
        grid-template-columns: 0.6fr 1.8fr 1fr;
        gap: 0.3rem;
    }
    
    .action-buttons .btn {
        font-size: 0.85rem;
    }
}

/* Animación de impresión para el ticket */
@keyframes printAnimation {
    0% { transform: scale(0.95); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

.receiptify-ticket {
    animation: printAnimation 0.5s ease-out;
}

/* Efecto de papel de ticket */
.receiptify-ticket::before {
    content: '';
    position: absolute;
    top: 0;
    left: 20px;
    right: 20px;
    height: 4px;
    background: repeating-linear-gradient(
        90deg,
        transparent,
        transparent 5px,
        var(--color-negro) 5px,
        var(--color-negro) 10px
    );
}

.receiptify-ticket::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 20px;
    right: 20px;
    height: 4px;
    background: repeating-linear-gradient(
        90deg,
        transparent,
        transparent 5px,
        var(--color-negro) 5px,
        var(--color-negro) 10px
    );
}
</style>
@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preparar datos de reserva para JS
    const reservaId = "{{ str_pad($reserva->id, 4, '0', STR_PAD_LEFT) }}";
    const reservaFecha = "{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}";
    const reservaHora = "{{ $reserva->hora }}";

    // Descargar ticket como imagen
    document.getElementById('download-ticket').addEventListener('click', function() {
        const ticket = document.getElementById('ticketToDownload');
        
        // Mostrar loading
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generando...';
        this.disabled = true;
        
        html2canvas(ticket, {
            scale: 2,
            backgroundColor: '#FFFFFF',
            useCORS: true,
            logging: false,
            onclone: function(clonedDoc) {
                const clonedTicket = clonedDoc.getElementById('ticketToDownload');
                if (clonedTicket) {
                    clonedTicket.style.boxShadow = 'none';
                    clonedTicket.style.animation = 'none';
                }
            }
        }).then(canvas => {
            // Crear enlace de descarga
            const link = document.createElement('a');
            link.download = `reserva-${reservaId}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
            
            // Restaurar botón
            this.innerHTML = originalText;
            this.disabled = false;
        }).catch(error => {
            console.error('Error al generar imagen:', error);
            alert('Error al generar la imagen del ticket');
            this.innerHTML = originalText;
            this.disabled = false;
        });
    });
    
    // Compartir ticket
    document.getElementById('share-ticket').addEventListener('click', function() {
        const shareData = {
            title: `Reserva Barbería Elite #${reservaId}`,
            text: `Reserva confirmada para el ${reservaFecha} a las ${reservaHora} - Barbería Elite`,
            url: window.location.href
        };

        if (navigator.share) {
            // Compartir nativo (dispositivos móviles)
            navigator.share(shareData).catch(error => {
                console.log('Error al compartir:', error);
            });
        } else if (navigator.clipboard) {
            // Copiar al portapapeles
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Enlace de la reserva copiado al portapapeles');
            }).catch(error => {
                console.error('Error al copiar:', error);
                alert('Error al copiar el enlace');
            });
        } else {
            // Fallback para navegadores antiguos
            const tempInput = document.createElement('input');
            tempInput.value = window.location.href;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            alert('Enlace de la reserva copiado al portapapeles');
        }
    });

    // Efecto de impresión al cargar
    const ticket = document.getElementById('ticketToDownload');
    ticket.style.animation = 'printAnimation 0.5s ease-out';
});
</script>
@endpush