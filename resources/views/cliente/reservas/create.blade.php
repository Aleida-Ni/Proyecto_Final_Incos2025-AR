@extends('cliente.layout')

@section('title', 'Reservar con ' . $barbero->nombre . ' - Barbería Elite')

@push('css')
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

    .card-custom {
        background: linear-gradient(135deg, var(--color-blanco) 0%, var(--color-beige) 100%);
        border-radius: 20px;
        border: 2px solid var(--color-dorado);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .barbero-img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 15px;
        border: 3px solid var(--color-dorado);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .hora-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
        gap: 12px;
        margin: 20px 0;
    }

    .hora-disponible,
    .hora-no-disponible {
        width: 100%;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        border-radius: 10px;
        font-size: 14px;
        user-select: none;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid;
    }

    .hora-disponible {
        border-color: var(--color-dorado);
        color: var(--color-gris-oscuro);
        background: var(--color-blanco);
    }

    .hora-disponible:hover,
    .hora-disponible.selected {
        background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
        color: var(--color-negro);
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.3);
    }

    .hora-no-disponible {
        background: linear-gradient(135deg, var(--color-beige-oscuro) 0%, var(--color-beige) 100%);
        border-color: var(--color-gris-medio);
        color: var(--color-gris-medio);
        cursor: not-allowed;
        opacity: 0.6;
    }

    .btn-confirmar {
        background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
        color: var(--color-negro);
        border: none;
        border-radius: 25px;
        padding: 15px 40px;
        font-size: 18px;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.3);
    }

    .btn-confirmar:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(212, 175, 55, 0.4);
    }

    .btn-elegir-dia {
        background: transparent;
        border: 2px solid var(--color-dorado);
        color: var(--color-gris-oscuro);
        border-radius: 20px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-elegir-dia:hover {
        background: var(--color-dorado);
        color: var(--color-negro);
    }

    .fecha-seleccionada {
        background: linear-gradient(135deg, var(--color-dorado-claro) 0%, var(--color-beige) 100%);
        border-radius: 15px;
        padding: 15px;
        border: 2px solid var(--color-dorado);
    }

    #selectorFecha {
        background: var(--color-blanco);
        border: 2px solid var(--color-dorado);
        border-radius: 10px;
        padding: 12px;
        color: var(--color-gris-oscuro);
        font-weight: 600;
    }

    #selectorFecha:focus {
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        border-color: var(--color-dorado);
    }

    .modal-content {
        background: linear-gradient(135deg, var(--color-blanco) 0%, var(--color-beige) 100%);
        border-radius: 20px;
        border: 2px solid var(--color-dorado);
    }

    .barbero-info {
        text-align: center;
    }

    .barbero-nombre {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--color-gris-oscuro);
        margin: 15px 0 5px;
    }

    .barbero-cargo {
        color: var(--color-dorado);
        font-weight: 600;
        font-size: 1.1rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
    <div class="card card-custom mx-auto" style="max-width: 1000px;">
        <div class="card-body p-5">
            <h2 class="text-center mb-4 fw-bold text-gris-oscuro">
                <i class="fas fa-calendar-plus me-2"></i>Reservar con {{ $barbero->nombre }}
            </h2>

            <div class="row align-items-stretch">
                <!-- Información del Barbero -->
                <div class="col-md-4 text-center">
                    <div class="barbero-info">
                        <img src="{{ asset('storage/' . $barbero->imagen) }}" 
                             alt="Foto de {{ $barbero->nombre }}" 
                             class="barbero-img mb-4">
                        <h3 class="barbero-nombre">{{ $barbero->nombre }}</h3>
                        <p class="barbero-cargo">{{ $barbero->cargo }}</p>
                        @if($barbero->telefono)
                        <p class="text-gris-medio">
                            <i class="fas fa-phone me-2"></i>{{ $barbero->telefono }}
                        </p>
                        @endif
                    </div>
                </div>

                <!-- Formulario de Reserva -->
                <div class="col-md-8">
                    <form action="{{ route('cliente.reservar.store') }}" method="POST" id="formReserva">
                        @csrf
                        <input type="hidden" name="barbero_id" value="{{ $barbero->id }}">
                        <input type="hidden" name="fecha" id="fechaInput" value="{{ $fecha }}">
                        <input type="hidden" name="hora" id="horaInput">

                        <!-- Selector de Fecha -->
                        <div class="fecha-seleccionada mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong class="text-gris-oscuro">Fecha seleccionada:</strong>
                                    <div id="fechaSeleccionada" class="fw-bold text-dorado">{{ $fecha }}</div>
                                </div>
                                <button type="button" class="btn btn-elegir-dia" data-bs-toggle="modal" data-bs-target="#modalFecha">
                                    <i class="fas fa-calendar-alt me-2"></i>Cambiar Día
                                </button>
                            </div>
                        </div>

                        @if($errors->has('hora'))
                        <div class="alert alert-danger text-center mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first('hora') }}
                        </div>
                        @endif

                        <!-- Selector de Horas -->
                        <h5 class="text-gris-oscuro mb-3">
                            <i class="fas fa-clock me-2"></i>Selecciona una hora disponible:
                        </h5>
                        <div class="hora-grid">
                            @foreach($horas as $hora => $disponible)
                                @if($disponible)
                                    <label class="hora-disponible">
                                        <input type="radio" name="horaRadio" value="{{ $hora }}" hidden>
                                        {{ $hora }}
                                    </label>
                                @else
                                    <div class="hora-no-disponible" title="Hora no disponible">
                                        {{ $hora }}
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Botón de Confirmación -->
                        <div class="text-center mt-4">
                            <button type="button" class="btn-confirmar" id="btnConfirmar">
                                <i class="fas fa-calendar-check me-2"></i>Confirmar Reserva
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Fecha -->
<div class="modal fade" id="modalFecha" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dorado">
                <h5 class="modal-title text-negro fw-bold">
                    <i class="fas fa-calendar me-2"></i>Seleccionar Fecha
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <label for="selectorFecha" class="form-label fw-semibold text-gris-oscuro mb-3">
                    Elige la fecha para tu reserva:
                </label>
                <input type="date" id="selectorFecha" class="form-control" 
                       min="{{ date('Y-m-d') }}" value="{{ $fecha }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-custom" onclick="setFecha()">
                    <i class="fas fa-check me-1"></i>Confirmar Fecha
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ticket (confirmación) -->
<div class="modal fade" id="modalTicket" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dorado">
                <h5 class="modal-title text-negro fw-bold">
                    <i class="fas fa-ticket-alt me-2"></i>Confirmar Reserva
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3">
                <div id="ticket-content" class="ticket-confirmacion" style="padding:12px;">
                    <!-- Contenido dinámico del ticket -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">
                    <i class="fas fa-arrow-left me-1"></i>Volver
                </button>
                <button type="button" class="btn btn-custom" id="confirmarTicket">
                    <i class="fas fa-check-circle me-1"></i>Confirmar Reserva
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function setFecha() {
    const valor = document.getElementById('selectorFecha').value;
    if(valor) {
        const barberoId = "{{ $barbero->id }}";
        window.location.href = `/cliente/reservar/${barberoId}?fecha=${valor}`;
    } else {
        alert("Por favor selecciona una fecha válida.");
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Selección de horas
    document.querySelectorAll('.hora-disponible').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.hora-disponible').forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
            btn.querySelector('input[type=radio]').checked = true;
        });
    });

    // Confirmación de reserva
    document.getElementById('btnConfirmar').addEventListener('click', () => {
        const selected = document.querySelector('input[name="horaRadio"]:checked');
        if(!selected) {
            alert("Por favor selecciona una hora disponible.");
            return;
        }

        document.getElementById('horaInput').value = selected.value;

        // Generar contenido del ticket
        const ticketContent = document.getElementById('ticket-content');
        ticketContent.innerHTML = `
            <div class="text-center mb-4">
                <h4 class="text-gris-oscuro fw-bold">BARBERÍA ELITE</h4>
                <p class="text-gris-medio">Reserva de Cita</p>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong class="text-gris-oscuro">Barbero:</strong><br>
                    {{ $barbero->nombre }}
                </div>
                <div class="col-md-6 text-end">
                    <strong class="text-gris-oscuro">Especialidad:</strong><br>
                    {{ $barbero->cargo ?? 'Barbería Premium' }}
                </div>
            </div>

            <div class="reserva-detalle bg-beige p-3 rounded mb-3">
                <div class="row text-center">
                    <div class="col-md-6 mb-2">
                        <strong class="text-gris-oscuro">Fecha</strong><br>
                        <span class="fw-bold text-dorado">${document.getElementById('fechaInput').value}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong class="text-gris-oscuro">Hora</strong><br>
                        <span class="fw-bold text-dorado">${selected.value}</span>
                    </div>
                </div>
            </div>

            <div class="cliente-info">
                <strong class="text-gris-oscuro">Cliente:</strong><br>
                {{ auth()->user()->nombre }} {{ auth()->user()->apellido_paterno }}
            </div>

            <div class="alert alert-info mt-3 mb-0">
                <i class="fas fa-info-circle me-2"></i>
                Por favor llega 5 minutos antes de tu cita programada.
            </div>
        `;

        // Mostrar modal de confirmación
        const modalTicket = new bootstrap.Modal(document.getElementById('modalTicket'));
        modalTicket.show();
    });

    // Confirmar reserva final
    document.getElementById('confirmarTicket').addEventListener('click', () => {
        document.getElementById('formReserva').submit();
    });

    // Efecto en horas no disponibles
    document.querySelectorAll('.hora-no-disponible').forEach(btn => {
        btn.addEventListener('click', () => {
            btn.style.transform = 'scale(0.95)';
            setTimeout(() => {
                btn.style.transform = 'scale(1)';
            }, 150);
        });
    });
});
</script>

<style>
    /* Versión profesional: quitar amarillo/dorado y usar paleta neutra */
    .bg-dorado {
        background: transparent !important;
    }

    .text-negro {
        color: #111827 !important;
    }

    .btn-custom {
        background: #111827;
        color: #ffffff;
        border: none;
        border-radius: 12px;
        padding: 8px 18px;
        font-weight: 600;
    }

    .btn-outline-custom {
        border: 1px solid #d1d5db;
        color: #374151;
        background: transparent;
        border-radius: 12px;
        padding: 8px 18px;
        font-weight: 600;
    }

    .ticket-confirmacion {
        background: #ffffff;
        border-radius: 10px;
        padding: 12px;
        border: 1px solid #e6e9ee;
    }

    .reserva-detalle {
        border-left: 3px solid #e6e9ee;
        padding-left: 10px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection