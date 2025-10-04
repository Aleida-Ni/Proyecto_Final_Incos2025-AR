@extends('adminlte::page')

@section('title', 'Marcar Reserva como Realizada')

@section('content_header')
    <h1>Completar Reserva #{{ $reserva->id }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <!-- Información de la reserva -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Información del Cliente</h5>
                <p><strong>Nombre:</strong> {{ $reserva->cliente->nombre ?? 'Cliente' }}</p>
                <p><strong>Teléfono:</strong> {{ $reserva->cliente->telefono ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <h5>Detalles de la Cita</h5>
                <p><strong>Barbero:</strong> {{ $reserva->barbero->nombre }}</p>
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</p>
                <p><strong>Hora:</strong> {{ $reserva->hora }}</p>
            </div>
        </div>

        <form action="{{ route('admin.reservas.marcar-realizada.store', $reserva) }}" method="POST">
            @csrf

            <!-- Selección de servicios -->
            <div class="form-group">
                <label><strong>Servicios Realizados *</strong></label>
                <div class="row">
                    @foreach($servicios as $servicio)
                    <div class="col-md-4 mb-2">
                        <div class="card servicio-card">
                            <div class="card-body">
                                <div class="form-check">
                                    <input class="form-check-input servicio-checkbox" 
                                           type="checkbox" 
                                           name="servicios[]" 
                                           value="{{ $servicio->id }}"
                                           id="servicio{{ $servicio->id }}"
                                           data-precio="{{ $servicio->precio }}">
                                    <label class="form-check-label" for="servicio{{ $servicio->id }}">
                                        <strong>{{ $servicio->nombre }}</strong><br>
                                        <small class="text-muted">{{ $servicio->descripcion }}</small><br>
                                        <span class="text-success font-weight-bold">${{ number_format($servicio->precio, 2) }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Total calculado -->
            <div class="form-group">
                <h4 class="text-primary">Total: $<span id="totalCalculado">0.00</span></h4>
            </div>

            <!-- Método de pago -->
            <div class="form-group">
                <label><strong>Método de Pago *</strong></label>
                <select name="metodo_pago" class="form-control" required>
                    <option value="">Seleccionar método de pago</option>
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="transferencia">Transferencia</option>
                </select>
            </div>

            <!-- Referencia de pago -->
            <div class="form-group">
                <label>Referencia de Pago (opcional)</label>
                <input type="text" name="referencia_pago" class="form-control" placeholder="Número de transacción o referencia">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-check-circle"></i> Marcar como Realizada y Registrar Pago
                </button>
                <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@stop

@push('css')
<style>
.servicio-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.servicio-card:hover {
    border-color: #007bff;
    transform: translateY(-2px);
}

.servicio-card.selected {
    border-color: #28a745;
    background-color: #f8fff9;
}

.form-check-input:checked + .form-check-label {
    font-weight: bold;
}
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.servicio-checkbox');
    const totalElement = document.getElementById('totalCalculado');

    function calcularTotal() {
        let total = 0;
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                total += parseFloat(checkbox.dataset.precio);
            }
        });
        totalElement.textContent = total.toFixed(2);
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            calcularTotal();
            // Agregar clase selected al card padre
            const card = this.closest('.servicio-card');
            if (this.checked) {
                card.classList.add('selected');
            } else {
                card.classList.remove('selected');
            }
        });
    });

    // Calcular total inicial
    calcularTotal();
});
</script>
@endpush