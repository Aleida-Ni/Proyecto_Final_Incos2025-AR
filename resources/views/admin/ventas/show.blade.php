@extends('adminlte::page')
@section('title', 'Detalle de Venta')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <!-- Ticket estilo Receiptify -->
            <div class="ticket-container" id="ticket-content">
                <div class="ticket-header">
                    <h1>BARBERÍA ELITE</h1>
                    <p class="tagline">Tu estilo, nuestra pasión</p>
                </div>
                
                <div class="ticket-section">
                    <div class="section-title">VENTA #{{ str_pad($venta->codigo, 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="section-content">
                        <div class="ticket-row">
                            <span>CLIENTE</span>
                            <span>{{ $venta->cliente->nombre ?? 'Cliente General' }}</span>
                        </div>
                        <div class="ticket-row">
                            <span>EMPLEADO</span>
                            <span>{{ $venta->empleado->nombre ?? 'N/A' }} {{ $venta->empleado->apellido_paterno ?? '' }}</span>
                        </div>
                        <div class="ticket-row">
                            <span>FECHA</span>
                            <span>{{ $venta->creado_en->format('d/m/Y') }}</span>
                        </div>
                        <div class="ticket-row">
                            <span>HORA</span>
                            <span>{{ $venta->creado_en->format('H:i:s') }}</span>
                        </div>
                        <div class="ticket-row">
                            <span>ESTADO</span>
                            <span class="status-{{ $venta->estado }}">{{ strtoupper($venta->estado) }}</span>
                        </div>
                    </div>
                </div>

                <div class="ticket-section">
                    <div class="section-title">DETALLES DE COMPRA</div>
                    <div class="items-table">
                        <div class="table-header">
                            <span>QTY</span>
                            <span>PRODUCTO</span>
                            <span>SUBTOTAL</span>
                        </div>
                        @foreach($venta->detalles as $det)
                        <div class="table-row">
                            <span>{{ $det->cantidad }}</span>
                            <span>{{ $det->producto->nombre }}</span>
                            <span>Bs. {{ number_format($det->subtotal, 2) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="ticket-section">
                    <div class="section-content">
                        <div class="ticket-row total-row">
                            <span>ITEM COUNT:</span>
                            <span>{{ $venta->detalles->count() }}</span>
                        </div>
                        <div class="ticket-row total-row">
                            <span>TOTAL:</span>
                            <span>Bs. {{ number_format($venta->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="ticket-section">
                    <div class="section-title">INFORMACIÓN DE PAGO</div>
                    <div class="section-content">
                        <div class="ticket-row">
                            <span>MÉTODO</span>
                            <span>{{ strtoupper($venta->metodo_pago) }}</span>
                        </div>
                        @if($venta->referencia_pago)
                        <div class="ticket-row">
                            <span>REFERENCIA</span>
                            <span>{{ $venta->referencia_pago }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="ticket-footer">
                    <p class="thank-you">¡GRACIAS POR SU VISITA!</p>
                    <p class="website">barberiaelite.com</p>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="action-buttons mt-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="{{ route('admin.ventas.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left me-2"></i>Volver
                        </a>
                    </div>
                    <div class="col-md-4">
                        <button id="download-ticket" class="btn btn-outline-primary w-100">
                            <i class="fas fa-download me-2"></i>Descargar
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button id="share-ticket" class="btn btn-outline-success w-100">
                            <i class="fas fa-share-alt me-2"></i>Compartir
                        </button>
                    </div>
                </div>
                
                @if($venta->estado === 'completada')
                <div class="row mt-3">
                    <div class="col-12">
                        <form action="{{ route('admin.ventas.destroy', $venta) }}" method="POST" class="d-inline w-100">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('¿Anular esta venta?')">
                                <i class="fas fa-ban me-2"></i>Anular Venta
                            </button>
                        </form>
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
    --color-dorado-claro: #F4E4A8;
}

.ticket-container {
    background: var(--color-blanco);
    border: 2px solid var(--color-negro);
    border-radius: 8px;
    padding: 2rem;
    font-family: 'Courier New', monospace;
    max-width: 400px;
    margin: 0 auto;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.ticket-header {
    text-align: center;
    border-bottom: 2px dashed var(--color-negro);
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
}

.ticket-header h1 {
    font-weight: 900;
    font-size: 1.8rem;
    margin: 0;
    color: var(--color-negro);
    letter-spacing: 1px;
}

.tagline {
    font-size: 0.9rem;
    color: var(--color-gris-medio);
    margin: 0.5rem 0 0 0;
    font-style: italic;
}

.ticket-section {
    margin-bottom: 1.5rem;
}

.section-title {
    font-weight: 700;
    font-size: 0.9rem;
    text-transform: uppercase;
    margin-bottom: 0.75rem;
    color: var(--color-negro);
    border-bottom: 1px solid var(--color-negro);
    padding-bottom: 0.25rem;
}

.section-content {
    font-size: 0.85rem;
}

.ticket-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.4rem;
}

.ticket-row span:first-child {
    font-weight: 600;
}

.ticket-row span:last-child {
    text-align: right;
}

.status-completada {
    color: #28a745;
    font-weight: 700;
}

.status-pendiente {
    color: #ffc107;
    font-weight: 700;
}

.status-cancelada {
    color: #dc3545;
    font-weight: 700;
}

.items-table {
    font-size: 0.8rem;
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
}

.table-row {
    border-bottom: 1px dashed #ccc;
}

.table-row:last-child {
    border-bottom: none;
}

.total-row {
    font-weight: 700;
    font-size: 0.9rem;
    border-top: 1px solid var(--color-negro);
    padding-top: 0.5rem;
    margin-top: 0.5rem;
}

.ticket-footer {
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
}

.website {
    font-size: 0.8rem;
    color: var(--color-gris-medio);
    margin: 0;
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
}

.btn-outline-success:hover {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
}

/* Responsive */
@media (max-width: 576px) {
    .ticket-container {
        padding: 1.5rem;
        margin: 0 1rem;
    }
    
    .ticket-header h1 {
        font-size: 1.5rem;
    }
    
    .table-header, .table-row {
        grid-template-columns: 0.6fr 1.8fr 1fr;
        gap: 0.3rem;
    }
}
</style>
@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Descargar ticket como imagen
    document.getElementById('download-ticket').addEventListener('click', function() {
        const ticket = document.getElementById('ticket-content');
        
        // Mostrar loading
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generando...';
        this.disabled = true;
        
        html2canvas(ticket, {
            scale: 2,
            backgroundColor: '#FFFFFF',
            useCORS: true,
            logging: false
        }).then(canvas => {
            // Crear enlace de descarga
            const link = document.createElement('a');
            link.download = `ticket-venta-{{ $venta->codigo }}.png`;
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
        if (navigator.share) {
            // Compartir nativo (dispositivos móviles)
            navigator.share({
                title: 'Ticket de Venta #{{ $venta->codigo }}',
                text: `Ticket de venta de Barbería Elite - Total: Bs. {{ number_format($venta->total, 2) }}`,
                url: window.location.href
            }).catch(error => {
                console.log('Error al compartir:', error);
            });
        } else if (navigator.clipboard) {
            // Copiar al portapapeles
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Enlace copiado al portapapeles');
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
            alert('Enlace copiado al portapapeles');
        }
    });
});
</script>
@endpush