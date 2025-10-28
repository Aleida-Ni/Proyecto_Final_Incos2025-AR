@extends('adminlte::page')

@section('title', 'Completar Reserva')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0"><i class="fas fa-check-circle text-gold"></i> Completar Reserva #{{ $reserva->id }}</h1>
        <a href="{{ route('admin.reservas.index') }}" class="btn btn-outline-custom">
            <i class="fas fa-arrow-left mr-2"></i> Volver
        </a>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-lg custom-card">
                <div class="card-header custom-card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-info-circle mr-2"></i>Información de la Reserva</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <strong><i class="fas fa-user text-dorado mr-2"></i>Cliente:</strong> 
                                {{ $reserva->cliente->nombre ?? 'N/A' }}
                            </div>
                            <div class="info-item mb-3">
                                <strong><i class="fas fa-phone text-dorado mr-2"></i>Teléfono:</strong> 
                                {{ $reserva->cliente->telefono ?? 'N/A' }}
                            </div>
                            <div class="info-item mb-3">
                                <strong><i class="fas fa-user-shield text-dorado mr-2"></i>Barbero:</strong> 
                                {{ $reserva->barbero->nombre ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <strong><i class="fas fa-calendar text-dorado mr-2"></i>Fecha:</strong> 
                                {{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}
                            </div>
                            <div class="info-item mb-3">
                                <strong><i class="fas fa-clock text-dorado mr-2"></i>Hora:</strong> 
                                {{ $reserva->hora }}
                            </div>
                            <div class="info-item mb-3">
                                <strong><i class="fas fa-tag text-dorado mr-2"></i>Estado:</strong> 
                                <span class="badge bg-warning">Pendiente</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg custom-card mt-4">
                <div class="card-header custom-card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-concierge-bell mr-2"></i>Servicios Realizados</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                    <div class="alert alert-danger alert-custom">
                        <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger alert-custom">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Por favor corrige los siguientes errores:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.reservas.completar', $reserva) }}" method="POST" id="completarForm">
                        @csrf
                        
                        <div class="form-group mb-4">
                            <label class="form-label custom-label">
                                <i class="fas fa-list-check text-dorado mr-2"></i>Seleccionar Servicios:
                            </label>
                            <div class="row">
                                @foreach($servicios as $servicio)
                                <div class="col-md-6 mb-3">
                                    <div class="service-card">
                                        <div class="form-check">
                                            <input class="form-check-input servicio-checkbox" 
                                                   type="checkbox" 
                                                   name="servicios[]" 
                                                   value="{{ $servicio->id }}"
                                                   data-precio="{{ $servicio->precio }}"
                                                   id="servicio{{ $servicio->id }}">
                                            <label class="form-check-label w-100" for="servicio{{ $servicio->id }}">
                                                <div class="service-info">
                                                    <strong class="text-gris-oscuro">{{ $servicio->nombre }}</strong>
                                                    <div class="service-details text-gris-medio">
                                                        <small>
                                                            <i class="fas fa-clock"></i> {{ $servicio->duracion_minutos }} min • 
                                                            Bs {{ number_format($servicio->precio, 2) }}
                                                        </small>
                                                    </div>
                                                    @if($servicio->descripcion)
                                                    <div class="service-description">
                                                        <small class="text-muted">{{ $servicio->descripcion }}</small>
                                                    </div>
                                                    @endif
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label custom-label">
                                        <i class="fas fa-credit-card text-dorado mr-2"></i>Método de Pago:
                                    </label>
                                    <select name="metodo_pago" class="form-control custom-input" required>
                                        <option value="">Seleccionar método...</option>
                                        <option value="efectivo">Efectivo</option>
                                        <option value="qr">QR</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label custom-label">
                                        <i class="fas fa-calculator text-dorado mr-2"></i>Monto Total:
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-beige text-gris-oscuro">Bs</span>
                                        <input type="number" 
                                               name="monto_total" 
                                               class="form-control custom-input" 
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


                        <div class="text-center mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-custom btn-lg px-5">
                                <i class="fas fa-check-circle mr-2"></i> Confirmar y Completar Reserva
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-lg custom-card">
                <div class="card-header custom-card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-receipt mr-2"></i>Resumen</h5>
                </div>
                <div class="card-body">
                    <div id="resumenServicios">
                        <p class="text-muted text-center">Selecciona los servicios realizados</p>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="text-gris-oscuro">Total:</strong>
                        <strong class="text-success h5" id="totalResumen">Bs 0.00</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contenedor oculto para pasar datos antiguos al script de forma segura -->
<div id="old-servicios" style="display:none;" data-servicios='@json(old("servicios", []))'></div>
@endsection

@section('css')
<style>
/* Estilos específicos para completar reserva */
.service-card {
    border: 1px solid var(--color-beige-oscuro);
    border-radius: 8px;
    padding: 12px;
    transition: all 0.3s ease;
    background: var(--color-blanco);
}

.service-card:hover {
    border-color: var(--color-dorado);
    box-shadow: 0 2px 8px rgba(212, 175, 55, 0.2);
    transform: translateY(-2px);
}

.service-card .form-check-input:checked + .form-check-label .service-info {
    color: var(--color-dorado);
}

.service-info {
    cursor: pointer;
}

.service-details {
    margin-top: 5px;
}

.service-description {
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px solid var(--color-beige);
}

.info-item {
    padding: 8px 0;
    border-bottom: 1px solid var(--color-beige);
}

.info-item:last-child {
    border-bottom: none;
}
</style>
@endsection

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
                html += `<div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-gris-oscuro">${servicio.nombre}</span>
                    <span class="text-success">$${servicio.precio.toFixed(2)}</span>
                </div>`;
            });
            resumenServicios.innerHTML = html;
        } else {
            resumenServicios.innerHTML = '<p class="text-muted text-center">Selecciona los servicios realizados</p>';
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

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Procesando...';
        submitBtn.disabled = true;
    });

    function mostrarAlerta(mensaje, tipo = 'danger') {
        // Remover alertas existentes
        const alertasExistentes = document.querySelectorAll('.alert.alert-custom');
        alertasExistentes.forEach(alerta => alerta.remove());

        const alerta = document.createElement('div');
        alerta.className = `alert alert-${tipo} alert-custom alert-dismissible`;
        alerta.innerHTML = `
            <i class="fas fa-${tipo === 'danger' ? 'exclamation-triangle' : 'info-circle'} mr-2"></i> 
            ${mensaje}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        `;
        
        const cardBody = document.querySelector('.card-body');
        cardBody.insertBefore(alerta, cardBody.firstChild);
        
        setTimeout(() => {
            if (alerta.parentNode) {
                alerta.remove();
            }
        }, 5000);
    }

    // Cargar servicios previamente seleccionados
    const oldServiciosEl = document.getElementById('old-servicios');
    if (oldServiciosEl) {
        try {
            const serviciosViejos = JSON.parse(oldServiciosEl.dataset.servicios || '[]');
            if (Array.isArray(serviciosViejos) && serviciosViejos.length > 0) {
                const serviciosViejosStr = serviciosViejos.map(String);
                checkboxes.forEach(checkbox => {
                    if (serviciosViejosStr.includes(checkbox.value)) {
                        checkbox.checked = true;
                    }
                });
                actualizarResumen();
            }
        } catch (e) {
            console.warn('No se pudo parsear servicios antiguos:', e);
        }
    }
});
</script>
@endsection