@extends('adminlte::page')

@section('title', 'Completar Reserva')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Completar Reserva #{{ $reserva->id }}</h1>
    <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Información de la Reserva</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Cliente:</strong> {{ $reserva->cliente->nombre ?? 'N/A' }}<br>
                        <strong>Teléfono:</strong> {{ $reserva->cliente->telefono ?? 'N/A' }}<br>
                        <strong>Barbero:</strong> {{ $reserva->barbero->nombre ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}<br>
                        <strong>Hora:</strong> {{ $reserva->hora }}<br>
                        <strong>Estado:</strong> <span class="badge bg-warning">Pendiente</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">Servicios Realizados</h5>
            </div>
            <div class="card-body">
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('admin.reservas.completar', $reserva) }}" method="POST" id="completarForm">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Seleccionar Servicios:</label>
                        <div class="row">
                            @foreach($servicios as $servicio)
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input servicio-checkbox" 
                                           type="checkbox" 
                                           name="servicios[]" 
                                           value="{{ $servicio->id }}"
                                           data-precio="{{ $servicio->precio }}"
                                           id="servicio{{ $servicio->id }}">
                                    <label class="form-check-label" for="servicio{{ $servicio->id }}">
                                        <strong>{{ $servicio->nombre }}</strong><br>
                                        <small class="text-muted">
                                            {{ $servicio->descripcion }} | 
                                            ${{ number_format($servicio->precio, 2) }} | 
                                            {{ $servicio->duracion_minutos }} min
                                        </small>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Método de Pago:</label>
                                    <select name="metodo_pago" class="form-select" required>
                                        <option value="">Seleccionar método...</option>
                                        <option value="efectivo">Efectivo</option>
                                        <option value="qr">QR</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Monto Total:</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" 
                                           name="monto_total" 
                                           class="form-control" 
                                           id="montoTotal"
                                           step="0.01" 
                                           min="0" 
                                           required
                                           readonly>
                                </div>
                                <small class="text-muted">Monto calculado automáticamente</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Observaciones:</label>
                        <textarea name="observaciones" class="form-control" rows="3" 
                                  placeholder="Observaciones adicionales..."></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-check-circle"></i> Confirmar y Completar Reserva
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Resumen</h5>
            </div>
            <div class="card-body">
                <div id="resumenServicios">
                    <p class="text-muted">Selecciona los servicios realizados</p>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <strong>Total:</strong>
                    <strong id="totalResumen">$0.00</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.servicio-checkbox');
    const montoTotal = document.getElementById('montoTotal');
    const resumenServicios = document.getElementById('resumenServicios');
    const totalResumen = document.getElementById('totalResumen');
    const form = document.getElementById('completarForm');
    const submitBtn = form.querySelector('button[type="submit"]');

    function actualizarResumen() {
        let total = 0;
        let serviciosSeleccionados = [];
        
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const precio = parseFloat(checkbox.dataset.precio);
                total += precio;
                serviciosSeleccionados.push({
                    nombre: checkbox.parentElement.querySelector('strong').textContent,
                    precio: precio
                });
            }
        });

        // Actualizar monto total
        montoTotal.value = total.toFixed(2);
        totalResumen.textContent = `$${total.toFixed(2)}`;

        // Actualizar resumen
        if (serviciosSeleccionados.length > 0) {
            let html = '';
            serviciosSeleccionados.forEach(servicio => {
                html += `<div class="d-flex justify-content-between mb-1">
                    <span class="small">${servicio.nombre}</span>
                    <span class="small">$${servicio.precio.toFixed(2)}</span>
                </div>`;
            });
            resumenServicios.innerHTML = html;
        } else {
            resumenServicios.innerHTML = '<p class="text-muted">Selecciona los servicios realizados</p>';
        }
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', actualizarResumen);
    });

    form.addEventListener('submit', function(e) {
        // Validar que se hayan seleccionado servicios
        const serviciosSeleccionados = document.querySelectorAll('.servicio-checkbox:checked');
        if (serviciosSeleccionados.length === 0) {
            e.preventDefault();
            mostrarAlerta('Por favor selecciona al menos un servicio', 'danger');
            return;
        }

        // Validar método de pago
        const metodoPago = document.querySelector('select[name="metodo_pago"]');
        if (!metodoPago.value) {
            e.preventDefault();
            mostrarAlerta('Por favor selecciona un método de pago', 'danger');
            return;
        }

        // Validar monto total
        if (!montoTotal.value || parseFloat(montoTotal.value) <= 0) {
            e.preventDefault();
            mostrarAlerta('El monto total debe ser mayor a 0', 'danger');
            return;
        }

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
        submitBtn.disabled = true;
    });

    function mostrarAlerta(mensaje, tipo = 'danger') {
        const alerta = document.createElement('div');
        alerta.className = `alert alert-${tipo} alert-dismissible fade show`;
        alerta.innerHTML = `
            <i class="fas fa-${tipo === 'danger' ? 'exclamation-triangle' : 'info-circle'}"></i> 
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const content = document.querySelector('.content');
        content.insertBefore(alerta, content.firstChild);
        
        setTimeout(() => {
            if (alerta.parentNode) {
                alerta.remove();
            }
        }, 5000);
    }

    @if(old('servicios'))
        const serviciosViejos = {!! json_encode(old('servicios')) !!};
        checkboxes.forEach(checkbox => {
            if (serviciosViejos.includes(checkbox.value)) {
                checkbox.checked = true;
            }
        });
        actualizarResumen();
    @endif
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@stop