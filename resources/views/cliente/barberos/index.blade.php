@extends('cliente.layout')

@section('title', 'Nuestros Barberos - Barbería Elite')

@section('content')
<div class="container my-5">

    <!-- MOSTRAR MODAL DE TICKET SI HAY RESERVA NUEVA -->
    @if(session('reserva_creada'))
        @php
            $reservaRecienCreada = \App\Models\Reserva::with('barbero')->find(session('reserva_creada'));
        @endphp
        @if($reservaRecienCreada)
        <div class="modal fade show" id="modalTicketRecienCreado" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5);" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
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
                                    <span class="ticket-value">{{ str_pad($reservaRecienCreada->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                
                                <div class="ticket-row mb-2">
                                    <span class="ticket-label">CLIENTE</span>
                                    <span class="ticket-value">{{ Auth::user()->nombre ?? 'Cliente' }}</span>
                                </div>
                                
                                <div class="ticket-divider-light my-2"></div>
                                
                                <div class="ticket-row mb-2">
                                    <span class="ticket-label">BARBERO</span>
                                    <span class="ticket-value">{{ $reservaRecienCreada->barbero->nombre }}</span>
                                </div>
                                
                                <div class="ticket-row mb-2">
                                    <span class="ticket-label">FECHA</span>
                                    <span class="ticket-value">{{ \Carbon\Carbon::parse($reservaRecienCreada->fecha)->format('d/m/Y') }}</span>
                                </div>
                                
                                <div class="ticket-row mb-2">
                                    <span class="ticket-label">HORA</span>
                                    <span class="ticket-value">{{ $reservaRecienCreada->hora }}</span>
                                </div>
                                
                                <div class="ticket-divider-light my-2"></div>
                                
                                <div class="ticket-row mb-2">
                                    <span class="ticket-label">ESTADO</span>
                                    <span class="ticket-value">
                                        <span class="badge bg-warning text-dark ticket-badge">
                                            Pendiente
                                        </span>
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Pie del ticket -->
                            <div class="ticket-footer text-center py-3">
                                <div class="ticket-divider mb-2"></div>
                                <p class="mb-1 small">¡Reserva confirmada exitosamente!</p>
                                <p class="mb-0 small text-muted">{{ now()->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center py-3">
                        <button type="button" class="btn btn-outline-secondary btn-sm me-2" onclick="cerrarTicket()">
                            <i class="fas fa-times me-1"></i>Cerrar
                        </button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="descargarTicketRecienCreado()">
                            <i class="fas fa-download me-1"></i>Descargar Ticket
                        </button>
                        <a href="{{ route('cliente.reservas') }}" class="btn btn-success btn-sm ms-2">
                            <i class="fas fa-calendar-alt me-1"></i>Ver Mis Reservas
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif

    <!-- Encabezado elegante -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-gris-oscuro mb-3">Nuestros Barberos Expertos</h1>
        <p class="text-gris-medio fs-5">Elige al profesional perfecto para tu estilo</p>
    </div>

    <!-- Barra de acciones -->
    <div class="d-flex justify-content-between mb-4 flex-wrap gap-3">
        <a href="{{ route('cliente.reservas') }}" class="btn btn-accion">
            <i class="fas fa-calendar-alt me-2"></i>Mis Reservas
        </a>

        <a href="{{ route('cliente.barberos.index') }}" class="btn btn-accion">
            <i class="fas fa-users me-2"></i>Ver Todos los Barberos
        </a>
    </div>

    <!-- Filtro elegante -->
    <div class="card filtro-card shadow-lg border-0 p-4 mb-5">
        <div class="card-body">
            <h5 class="filtro-titulo mb-4">
                <i class="fas fa-search me-2"></i>Encuentra tu horario perfecto
            </h5>
            <form action="{{ route('cliente.barberos.index') }}" method="GET" class="row g-4 align-items-end">
                <div class="col-lg-5 col-md-6">
                    <label for="fecha" class="form-label fw-semibold text-gris-oscuro">
                        <i class="fas fa-calendar-day me-1"></i>Selecciona un día
                    </label>
                    <div class="input-group input-group-elegante">
                        <span class="input-group-text">
                            <i class="fas fa-calendar-alt text-dorado"></i>
                        </span>
                        <input type="date" name="fecha" id="fecha" class="form-control"
                               value="{{ request('fecha') }}" min="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="col-lg-5 col-md-6">
                    <label for="hora" class="form-label fw-semibold text-gris-oscuro">
                        <i class="fas fa-clock me-1"></i>Selecciona una hora
                    </label>
                    <select name="hora" id="hora" class="form-select select-elegante">
                        <option value="">-- Todas las horas --</option>
                        @php
                            $horas = [
                                '09:00', '10:00', '11:00', '12:00',
                                '13:00', '14:00', '15:00', '16:00', '17:00'
                            ];
                        @endphp
                        @foreach ($horas as $hora)
                            <option value="{{ $hora }}" {{ request('hora') == $hora ? 'selected' : '' }}>
                                {{ $hora }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-12 text-end">
                    <button type="submit" class="btn btn-filtrar w-100">
                        <i class="fas fa-search me-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de barberos -->
    <div class="row g-4">
        @forelse ($barberos as $barbero)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card barbero-card border-0 shadow-sm h-100">
                    <div class="barbero-img-container">
                        @if($barbero->imagen)
                            <img src="{{ asset('storage/' . $barbero->imagen) }}" 
                                 class="barbero-img" 
                                 alt="Foto de {{ $barbero->nombre }}"
                                 loading="lazy">
                        @else
                            <div class="barbero-placeholder">
                                <i class="fas fa-user-circle fa-4x text-beige-oscuro"></i>
                            </div>
                        @endif
                        <div class="barbero-overlay">
                            <div class="overlay-content">
                                <a href="{{ route('cliente.reservar', $barbero->id) }}" class="btn btn-reservar">
                                    <i class="fas fa-calendar-check me-2"></i>Reservar Cita
                                </a>
                                <div class="barbero-info-overlay">
                                    <small class="text-blanco">
                                        <i class="fas fa-star me-1 text-dorado"></i>
                                        Especialista en {{ $barbero->cargo ?? 'Barbería' }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center p-4">
                        <h5 class="barbero-nombre fw-bold text-gris-oscuro mb-2">{{ $barbero->nombre }}</h5>
                        <p class="barbero-cargo text-dorado fw-semibold small mb-3 text-uppercase">
                            {{ $barbero->cargo ?? 'Barbero Profesional' }}
                        </p>
                        @if($barbero->telefono)
                            <div class="barbero-contacto text-gris-medio small">
                                <i class="fas fa-phone me-1"></i>{{ $barbero->telefono }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <!-- Estado vacío elegante -->
            <div class="col-12">
                <div class="empty-state text-center py-5">
                    <i class="fas fa-user-slash fa-4x text-beige-oscuro mb-4"></i>
                    <h3 class="text-gris-medio mb-3">No hay barberos disponibles</h3>
                    <p class="text-gris-medio mb-4">
                        @if(request('fecha') || request('hora'))
                            No encontramos barberos disponibles para los filtros seleccionados.
                        @else
                            Pronto tendremos nuevos barberos en nuestro equipo.
                        @endif
                    </p>
                    @if(request('fecha') || request('hora'))
                        <a href="{{ route('cliente.barberos.index') }}" class="btn btn-accion">
                            <i class="fas fa-times me-2"></i>Limpiar Filtros
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
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
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container.my-5 {
        margin-top: 120px !important;
        padding-top: 20px;
    }

    .text-center.mb-5 {
        padding-top: 30px;
    }

    @media (max-width: 768px) {
        .content-wrapper {
            margin-top: 180px !important;
        }
        
        .main-header.navbar.scrolled ~ .content-wrapper {
            margin-top: 150px !important;
        }
        
        h1 {
            font-size: 2.2rem;
            margin-top: 15px;
        }
    }

    /* Encabezado principal */
    h1 {
        background: linear-gradient(135deg, var(--color-gris-oscuro) 0%, var(--color-dorado) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 2.8rem;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    /* Botones de acción */
    .btn-accion {
        background: linear-gradient(135deg, var(--color-blanco) 0%, var(--color-beige) 100%);
        color: var(--color-gris-oscuro) !important;
        border: 2px solid var(--color-dorado);
        border-radius: 25px;
        padding: 12px 25px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
    }

    .btn-accion:hover {
        background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
        color: var(--color-negro) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.3);
    }

    /* Card de filtro */
    .filtro-card {
        background: linear-gradient(135deg, var(--color-blanco) 0%, var(--color-beige) 100%);
        border-radius: 20px;
        border: 2px solid var(--color-dorado);
    }

    .filtro-titulo {
        color: var(--color-gris-oscuro);
        font-weight: 600;
        font-size: 1.2rem;
        border-bottom: 2px solid var(--color-dorado);
        padding-bottom: 10px;
    }

    /* Inputs elegantes */
    .input-group-elegante {
        position: relative;
    }

    .input-group-elegante .input-group-text {
        background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
        border: 2px solid var(--color-dorado);
        border-right: none;
        color: var(--color-negro);
        font-weight: 600;
    }

    .input-group-elegante .form-control {
        border: 2px solid var(--color-dorado);
        border-left: none;
        background: var(--color-blanco);
        transition: all 0.3s ease;
    }

    .input-group-elegante .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        border-color: var(--color-dorado);
    }

    .select-elegante {
        border: 2px solid var(--color-dorado);
        background: var(--color-blanco);
        transition: all 0.3s ease;
    }

    .select-elegante:focus {
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        border-color: var(--color-dorado);
    }

    /* Botón de filtrar */
    .btn-filtrar {
        background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
        color: var(--color-negro);
        border: 2px solid var(--color-dorado);
        border-radius: 12px;
        padding: 12px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
    }

    .btn-filtrar:hover {
        background: linear-gradient(135deg, var(--color-dorado-claro) 0%, var(--color-dorado) 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
    }

    /* Tarjetas de barberos */
    .barbero-card {
        border-radius: 20px;
        transition: all 0.4s ease;
        overflow: hidden;
        background: var(--color-blanco);
        border: 1px solid var(--color-beige-oscuro);
    }

    .barbero-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        border-color: var(--color-dorado);
    }

    .barbero-img-container {
        position: relative;
        overflow: hidden;
        height: 280px;
    }

    .barbero-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .barbero-card:hover .barbero-img {
        transform: scale(1.1);
    }

    .barbero-placeholder {
        height: 100%;
        background: linear-gradient(135deg, var(--color-beige) 0%, var(--color-beige-oscuro) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-gris-medio);
    }

    /* Overlay elegante */
    .barbero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, 
                    rgba(0, 0, 0, 0) 0%, 
                    rgba(0, 0, 0, 0.8) 100%);
        display: flex;
        align-items: flex-end;
        opacity: 0;
        transition: opacity 0.4s ease;
        padding: 20px;
    }

    .barbero-card:hover .barbero-overlay {
        opacity: 1;
    }

    .overlay-content {
        width: 100%;
    }

    .btn-reservar {
        background: linear-gradient(135deg, var(--color-dorado) 0%, var(--color-dorado-claro) 100%);
        color: var(--color-negro) !important;
        border: none;
        border-radius: 25px;
        padding: 12px 25px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: block;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .btn-reservar:hover {
        background: linear-gradient(135deg, var(--color-dorado-claro) 0%, var(--color-dorado) 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
    }

    .barbero-info-overlay {
        margin-top: 10px;
        text-align: center;
    }

    /* Información del barbero */
    .barbero-nombre {
        font-size: 1.2rem;
        line-height: 1.4;
    }

    .barbero-cargo {
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }

    .barbero-contacto {
        font-weight: 500;
    }

    /* Estado vacío */
    .empty-state {
        padding: 4rem 2rem;
        background: linear-gradient(135deg, var(--color-beige) 0%, var(--color-blanco) 100%);
        border-radius: 20px;
        border: 2px solid var(--color-dorado);
    }

    /* Estilos del modal del ticket */
    .modal.show {
        display: block !important;
        opacity: 1 !important;
    }
    
    .ticket-container {
        background: #ffffff;
        font-family: 'Helvetica Neue', Arial, sans-serif;
        max-width: 320px;
        margin: 0 auto;
        box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    }

    .ticket-header {
        background: transparent;
        color: #111827;
        padding: 12px 10px;
        border-bottom: 1px solid #eef2f6;
    }

    .ticket-body {
        background: #ffffff;
        padding: 12px 10px;
    }

    .ticket-footer {
        background: #fafafa;
        border-top: 1px solid #eef2f6;
        padding: 12px 10px;
    }

    .ticket-divider {
        height: 1px;
        background: #e6e9ee;
        width: 90%;
        margin: 10px auto;
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

    /* Responsive */
    @media (max-width: 768px) {
        h1 {
            font-size: 2.2rem;
        }
        
        .btn-accion {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
        
        .barbero-img-container {
            height: 240px;
        }
        
        .filtro-card .row {
            gap: 15px;
        }
        
        .filtro-card .col-lg-2 {
            text-align: center !important;
        }

        .ticket-container {
            max-width: 280px;
        }
    }

    @media (max-width: 576px) {
        .container {
            padding: 0 15px;
        }
        
        h1 {
            font-size: 1.8rem;
        }
        
        .barbero-img-container {
            height: 200px;
        }
        
        .btn-reservar {
            padding: 10px 20px;
            font-size: 0.9rem;
        }

        .ticket-container {
            max-width: 260px;
        }
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Efecto de aparición suave para las tarjetas
        const barberoCards = document.querySelectorAll('.barbero-card');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        barberoCards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });

        // Establecer fecha mínima como hoy
        const fechaInput = document.getElementById('fecha');
        if (fechaInput) {
            const today = new Date().toISOString().split('T')[0];
            fechaInput.min = today;
            
            // Si no hay fecha seleccionada, establecer hoy como valor por defecto
            if (!fechaInput.value) {
                fechaInput.value = today;
            }
        }

        // Mejorar la interacción del input group
        const inputGroupText = document.querySelector('.input-group-text');
        if (inputGroupText) {
            inputGroupText.style.cursor = 'pointer';
            inputGroupText.addEventListener('click', () => {
                fechaInput.focus();
                fechaInput.showPicker?.(); // Para navegadores modernos
            });
        }
    });

function cerrarTicket() {
    const modalEl = document.getElementById('modalTicketRecienCreado');
    if (!modalEl) return;

    // Intentar cerrar con la API de Bootstrap
    try {
        const bsModal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        bsModal.hide();
    } catch (err) {
        // Ignorar, proceder a quitar el modal manualmente
    }

    // Remover el modal y backdrop del DOM para evitar problemas de z-index/scroll
    setTimeout(() => {
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) backdrop.remove();
        if (modalEl.parentNode) modalEl.parentNode.removeChild(modalEl);
        document.body.classList.remove('modal-open');
    }, 200);

    fetch('{{ route("cliente.limpiar.sesion.ticket") }}', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({})
    }).then(response => {
        if (!response.ok) {
            console.warn('La petición para limpiar la sesión del ticket devolvió estado', response.status);
        }
    }).catch(err => {
        console.error('No se pudo limpiar la sesión del ticket:', err);
    });
}

    async function descargarTicketRecienCreado() {
        try {
            const ticketElement = document.querySelector('#modalTicketRecienCreado .ticket-container');
            
            const downloadBtn = document.querySelector('#modalTicketRecienCreado .btn-primary');
            const originalText = downloadBtn.innerHTML;
            downloadBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Generando...';
            downloadBtn.disabled = true;

            const canvas = await html2canvas(ticketElement, {
                scale: 3,
                backgroundColor: '#ffffff',
                useCORS: true,
                logging: false,
                width: ticketElement.scrollWidth,
                height: ticketElement.scrollHeight
            });

            const imagen = canvas.toDataURL('image/png', 1.0);
            
            const enlace = document.createElement('a');
            enlace.download = `ticket-reserva-{{ $reservaRecienCreada->id ?? '0' }}.png`;
            enlace.href = imagen;
            
            document.body.appendChild(enlace);
            enlace.click();
            document.body.removeChild(enlace);

            downloadBtn.innerHTML = originalText;
            downloadBtn.disabled = false;

        } catch (error) {
            console.error('Error al generar el ticket:', error);
            alert('Error al generar el ticket. Inténtalo de nuevo.');
            
            const downloadBtn = document.querySelector('#modalTicketRecienCreado .btn-primary');
            if (downloadBtn) {
                downloadBtn.innerHTML = '<i class="fas fa-download me-1"></i>Descargar';
                downloadBtn.disabled = false;
            }
        }
    }

    document.addEventListener('click', function(e) {
        const modal = document.getElementById('modalTicketRecienCreado');
        if (modal && e.target === modal) {
            cerrarTicket();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarTicket();
        }
    });
</script>
@endsection