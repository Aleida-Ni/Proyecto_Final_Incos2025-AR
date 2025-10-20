@extends('adminlte::page')

@section('title', 'Reportes - Reservas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Reporte de Reservas</h1>
        <div>
            <a href="{{ route('admin.reportes.reservas.pdf', request()->query()) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-file-pdf"></i> Exportar PDF
            </a>
        </div>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <!-- FILTROS MEJORADOS -->
        <form method="GET" class="row g-3 mb-4 align-items-end" id="filterForm">
            <!-- Filtros rápidos -->
            <div class="col-md-2">
                <label class="form-label">Periodo rápido</label>
                <select name="periodo" class="form-select">
                    <option value="">-- Seleccionar --</option>
                    <option value="hoy" {{ request('periodo') == 'hoy' ? 'selected' : '' }}>Hoy</option>
                    <option value="7" {{ request('periodo') == '7' ? 'selected' : '' }}>Últimos 7 días</option>
                    <option value="15" {{ request('periodo') == '15' ? 'selected' : '' }}>Últimos 15 días</option>
                    <option value="30" {{ request('periodo') == '30' ? 'selected' : '' }}>Últimos 30 días</option>
                    <option value="mes" {{ request('periodo') == 'mes' ? 'selected' : '' }}>Este mes</option>
                    <option value="mes_pasado" {{ request('periodo') == 'mes_pasado' ? 'selected' : '' }}>Mes pasado</option>
                </select>
            </div>

            <!-- Filtro personalizado -->
            <div class="col-md-2">
                <label class="form-label">Desde</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}" id="fechaDesde">
            </div>
            <div class="col-md-2">
                <label class="form-label">Hasta</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}" id="fechaHasta">
            </div>

            <!-- Estado (oculto, se maneja por los botones) -->
            <input type="hidden" name="estado" id="estadoFilter" value="{{ request('estado') }}">

            <!-- Barbero -->
            <div class="col-md-2">
                <label class="form-label">Barbero</label>
                <select name="barbero_id" class="form-select">
                    <option value="">Todos</option>
                    @foreach($barberos as $barbero)
                        <option value="{{ $barbero->id }}" {{ request('barbero_id') == $barbero->id ? 'selected' : '' }}>
                            {{ $barbero->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Botones -->
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
                <a href="{{ route('admin.reportes.reservas') }}" class="btn btn-outline-secondary w-100 mt-1">
                    <i class="fas fa-undo"></i> Limpiar
                </a>
            </div>
        </form>

        <!-- MÉTRICAS Y ESTADÍSTICAS INTERACTIVAS -->
        @if(isset($estadisticas))
        <div class="row mb-4">
            <!-- Total Reservas -->
            <div class="col-md-2">
                <div class="card metric-card bg-primary text-white clickable-card" 
                     onclick="filterByStatus('')"
                     data-status="">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['total'] }}</h3>
                        <p class="card-text mb-0">
                            <i class="fas fa-calendar-alt me-1"></i>Total Reservas
                        </p>
                        <small class="opacity-75">Click para ver todas</small>
                    </div>
                </div>
            </div>
            
            <!-- Pendientes -->
            <div class="col-md-2">
                <div class="card metric-card bg-warning text-white clickable-card {{ request('estado') == 'pendiente' ? 'active-metric' : '' }}" 
                     onclick="filterByStatus('pendiente')"
                     data-status="pendiente">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['pendientes'] }}</h3>
                        <p class="card-text mb-0">
                            <i class="fas fa-clock me-1"></i>Pendientes
                        </p>
                        <small class="opacity-75">
                            @if($estadisticas['ingreso_pendiente'] > 0)
                            ${{ number_format($estadisticas['ingreso_pendiente'], 2) }}
                            @else
                            Sin ingresos
                            @endif
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Realizadas -->
            <div class="col-md-2">
                <div class="card metric-card bg-success text-white clickable-card {{ request('estado') == 'realizada' ? 'active-metric' : '' }}" 
                     onclick="filterByStatus('realizada')"
                     data-status="realizada">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['realizadas'] }}</h3>
                        <p class="card-text mb-0">
                            <i class="fas fa-check-circle me-1"></i>Realizadas
                        </p>
                        <small class="opacity-75">
                            ${{ number_format($estadisticas['ingreso_realizado'], 2) }}
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Canceladas -->
            <div class="col-md-2">
                <div class="card metric-card bg-danger text-white clickable-card {{ request('estado') == 'cancelada' ? 'active-metric' : '' }}" 
                     onclick="filterByStatus('cancelada')"
                     data-status="cancelada">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['canceladas'] }}</h3>
                        <p class="card-text mb-0">
                            <i class="fas fa-ban me-1"></i>Canceladas
                        </p>
                        <small class="opacity-75">
                            {{ $estadisticas['tasa_cancelacion'] }}% tasa
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- No Asistió -->
            <div class="col-md-2">
                <div class="card metric-card bg-dark text-white clickable-card {{ request('estado') == 'no_asistio' ? 'active-metric' : '' }}" 
                     onclick="filterByStatus('no_asistio')"
                     data-status="no_asistio">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['no_asistio'] }}</h3>
                        <p class="card-text mb-0">
                            <i class="fas fa-times me-1"></i>No Asistió
                        </p>
                        <small class="opacity-75">
                            {{ $estadisticas['tasa_no_asistencia'] }}% tasa
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Tasa Asistencia -->
            <div class="col-md-2">
                <div class="card metric-card bg-info text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $estadisticas['tasa_asistencia'] }}%</h3>
                        <p class="card-text mb-0">
                            <i class="fas fa-chart-line me-1"></i>Tasa Asistencia
                        </p>
                        <small class="opacity-75">
                            Total: ${{ number_format($estadisticas['ingreso_total'], 2) }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- RESUMEN FINANCIERO -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-light">
                    <div class="card-body py-2">
                        <div class="row text-center">
                            <div class="col-md-3 border-end">
                                <small class="text-muted">Ingreso Total Realizado</small>
                                <h5 class="mb-0 text-success">${{ number_format($estadisticas['ingreso_total'], 2) }}</h5>
                            </div>
                            <div class="col-md-3 border-end">
                                <small class="text-muted">Ingreso Pendiente</small>
                                <h5 class="mb-0 text-warning">${{ number_format($estadisticas['ingreso_pendiente'], 2) }}</h5>
                            </div>
                            <div class="col-md-3 border-end">
                                <small class="text-muted">Promedio por Reserva</small>
                                <h5 class="mb-0 text-primary">${{ number_format($estadisticas['promedio_reserva'], 2) }}</h5>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Reservas por Día</small>
                                <h5 class="mb-0 text-info">{{ number_format($estadisticas['reservas_por_dia'], 1) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- RESUMEN DEL REPORTE -->
        @if($reservas->count() > 0)
        <div class="alert alert-info mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>Reporte generado:</strong> 
                    {{ request('from') ? \Carbon\Carbon::parse(request('from'))->format('d/m/Y') : 'Inicio' }} 
                    al 
                    {{ request('to') ? \Carbon\Carbon::parse(request('to'))->format('d/m/Y') : 'Actual' }}
                    @if(request('estado'))
                    | <strong>Estado:</strong> 
                    <span class="badge 
                        @if(request('estado') == 'pendiente') bg-warning 
                        @elseif(request('estado') == 'realizada') bg-success 
                        @elseif(request('estado') == 'cancelada') bg-danger
                        @elseif(request('estado') == 'no_asistio') bg-dark
                        @endif">
                        {{ ucfirst(request('estado')) }}
                    </span>
                    @endif
                </div>
                <div>
                    <strong>Total registros:</strong> {{ $reservas->total() }}
                </div>
            </div>
        </div>
        @endif

        <!-- TABLA MEJORADA -->
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablaReservas">
                <thead class="table-dark">
                    <tr>
                        <th width="80">ID</th>
                        <th>Cliente</th>
                        <th>Contacto</th>
                        <th>Barbero</th>
                        <th width="110">Fecha</th>
                        <th width="90">Hora</th>
                        <th width="120">Estado</th>
                        <th width="120">Monto</th>
                        <th width="100" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservas as $r)
                        @php
                            $fechaReserva = \Carbon\Carbon::parse($r->fecha);
                            $esPasada = $fechaReserva->lt(\Carbon\Carbon::today());
                            $totalReserva = 0;
                            
                            // Calcular total de la reserva
                            if ($r->servicios && $r->servicios->count() > 0) {
                                $totalReserva = $r->servicios->sum('pivot.precio');
                            }
                            
                            // Si tiene venta asociada, usar ese monto
                            if ($r->venta) {
                                $totalReserva = $r->venta->total;
                            }
                        @endphp
                        <tr class="{{ $esPasada && $r->estado == 'pendiente' ? 'table-warning' : '' }}">
                            <td>
                                <strong>#{{ $r->id }}</strong>
                            </td>
                            <td>
                                <div class="fw-bold">{{ optional($r->cliente)->nombre ?? 'Cliente' }}</div>
                                <small class="text-muted">{{ optional($r->cliente)->correo ?? '' }}</small>
                            </td>
                            <td>
                                @if($r->cliente && $r->cliente->telefono)
                                    <small>
                                        <i class="fas fa-phone"></i> {{ $r->cliente->telefono }}
                                    </small>
                                @else
                                    <small class="text-muted">Sin contacto</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ optional($r->barbero)->nombre ?? '—' }}</span>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $fechaReserva->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $fechaReserva->locale('es')->dayName }}</small>
                            </td>
                            <td>
                                <span class="fw-bold">{{ $r->hora }}</span>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($r->estado=='pendiente') bg-warning 
                                    @elseif($r->estado=='realizada') bg-success 
                                    @elseif($r->estado=='cancelada') bg-danger
                                    @elseif($r->estado=='no_asistio') bg-dark
                                    @endif">
                                    {{ ucfirst($r->estado) }}
                                </span>
                                @if($esPasada && $r->estado == 'pendiente')
                                    <br><small class="text-danger"><i class="fas fa-clock"></i> Pasada</small>
                                @endif
                            </td>
                            <td>
                                @php
                                    $totalReserva = 0;
                                    // Si tiene venta asociada, usar ese monto
                                    if ($r->venta) {
                                        $totalReserva = $r->venta->total;
                                    } else {
                                        // Si no tiene venta, calcular de servicios
                                        $totalReserva = $r->servicios->sum('pivot.precio');
                                    }
                                @endphp
                                
                                @if($totalReserva > 0)
                                    <strong class="text-success">${{ number_format($totalReserva, 2) }}</strong>
                                    @if($r->venta && $r->venta->metodo_pago)
                                    <br><small class="text-muted">{{ ucfirst($r->venta->metodo_pago) }}</small>
                                    @elseif($r->estado == 'pendiente')
                                    <br><small class="text-warning">Pendiente</small>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-info btn-sm view-ticket-btn" 
                                        data-reserva-id="{{ $r->id }}"
                                        title="Ver ticket">
                                    <i class="fas fa-receipt"></i>
                                </button>
                                @if($r->estado == 'pendiente')
                                    <a href="{{ route('admin.reservas.completar', $r) }}" 
                                       class="btn btn-success btn-sm" 
                                       title="Completar reserva">
                                        <i class="fas fa-check"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No se encontraron reservas</h5>
                                <p class="text-muted">No hay registros con los filtros aplicados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINACIÓN -->
        @if($reservas->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Mostrando {{ $reservas->firstItem() }} - {{ $reservas->lastItem() }} de {{ $reservas->total() }} registros
            </div>
            {{ $reservas->links() }}
        </div>
        @endif
    </div>
</div>

<!-- MODAL PARA TICKETS -->
<div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white py-2">
                <h6 class="modal-title mb-0" id="ticketModalLabel">
                    <i class="fas fa-receipt me-1"></i>TICKET DE RESERVA
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="ticketContent">
                    <!-- El contenido del ticket se cargará aquí dinámicamente -->
                </div>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cerrar
                </button>
                <button type="button" class="btn btn-primary btn-sm" id="downloadTicketBtn">
                    <i class="fas fa-download me-1"></i>Descargar
                </button>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
// Función para filtrar por estado al hacer clic en las métricas
function filterByStatus(status) {
    console.log('Filtrando por estado:', status);
    
    // Establecer el valor del filtro de estado
    document.getElementById('estadoFilter').value = status;
    
    // Enviar el formulario
    document.getElementById('filterForm').submit();
}

// Función para limpiar todos los filtros
function limpiarFiltros() {
    document.getElementById('estadoFilter').value = '';
    document.getElementById('filterForm').submit();
}

// Variable global para almacenar el ticket actual
let currentTicketHtml = '';

// Función para mostrar el ticket
function showTicket(reservaId) {
    // Aquí deberías hacer una petición AJAX para obtener los datos de la reserva
    // Por ahora, simularé los datos basados en la información disponible
    
    const reserva = getReservaData(reservaId); // Esta función debería obtener los datos reales
    
    const ticketHtml = generateTicketHtml(reserva);
    document.getElementById('ticketContent').innerHTML = ticketHtml;
    currentTicketHtml = ticketHtml;
    
    const modal = new bootstrap.Modal(document.getElementById('ticketModal'));
    modal.show();
}

// Función para generar el HTML del ticket (simulada - deberías adaptarla a tus datos reales)
function generateTicketHtml(reserva) {
    const totalReserva = reserva.venta ? reserva.venta.total : 
                        (reserva.servicios && reserva.servicios.length > 0 ? 
                         reserva.servicios.reduce((sum, s) => sum + (s.pivot?.precio || s.precio || 0), 0) : 0);
    
    const metodoPago = reserva.metodo_pago || (reserva.venta ? reserva.venta.metodo_pago : null);
    
    return `
        <div class="ticket-container-modal" id="ticketToDownload">
            <div class="ticket-header-modal">
                <h1>BARBERÍA ELITE</h1>
                <p class="tagline-modal">Tu estilo, nuestra pasión</p>
            </div>
            
            <div class="ticket-section-modal">
                <div class="section-title-modal">RESERVA #${String(reserva.id).padStart(4, '0')}</div>
                <div class="section-content-modal">
                    <div class="ticket-row-modal">
                        <span>CLIENTE</span>
                        <span>${reserva.cliente?.nombre || 'N/A'}</span>
                    </div>
                    <div class="ticket-row-modal">
                        <span>BARBERO</span>
                        <span>${reserva.barbero?.nombre || 'N/A'}</span>
                    </div>
                    <div class="ticket-row-modal">
                        <span>FECHA</span>
                        <span>${new Date(reserva.fecha).toLocaleDateString('es-ES')}</span>
                    </div>
                    <div class="ticket-row-modal">
                        <span>HORA</span>
                        <span>${reserva.hora}</span>
                    </div>
                    <div class="ticket-row-modal">
                        <span>ESTADO</span>
                        <span class="status-${reserva.estado}">${reserva.estado.toUpperCase()}</span>
                    </div>
                </div>
            </div>

            ${reserva.servicios && reserva.servicios.length > 0 ? `
            <div class="ticket-section-modal">
                <div class="section-title-modal">SERVICIOS AGENDADOS</div>
                <div class="items-table-modal">
                    <div class="table-header-modal">
                        <span>QTY</span>
                        <span>SERVICIO</span>
                        <span>PRECIO</span>
                    </div>
                    ${reserva.servicios.map(servicio => `
                        <div class="table-row-modal">
                            <span>1</span>
                            <span>${servicio.nombre || servicio.servicio?.nombre}</span>
                            <span>$${(servicio.pivot?.precio || servicio.precio || 0).toFixed(2)}</span>
                        </div>
                    `).join('')}
                </div>
            </div>

            <div class="ticket-section-modal">
                <div class="section-content-modal">
                    <div class="ticket-row-modal total-row-modal">
                        <span>SERVICIOS:</span>
                        <span>${reserva.servicios.length}</span>
                    </div>
                    <div class="ticket-row-modal total-row-modal">
                        <span>TOTAL:</span>
                        <span>$${totalReserva.toFixed(2)}</span>
                    </div>
                    ${metodoPago ? `
                    <div class="ticket-row-modal">
                        <span>MÉTODO PAGO</span>
                        <span>${metodoPago.toUpperCase()}</span>
                    </div>
                    ` : ''}
                </div>
            </div>
            ` : `
            <div class="ticket-section-modal">
                <div class="section-content-modal text-center">
                    <em>No se registraron servicios</em>
                </div>
            </div>
            `}


            <div class="ticket-section-modal">
                <div class="section-content-modal">
                    <div class="ticket-row-modal">
                        <span>CREADO</span>
                        <span>${new Date(reserva.creado_en).toLocaleString('es-ES')}</span>
                    </div>
                    ${reserva.actualizado_en ? `
                    <div class="ticket-row-modal">
                        <span>ACTUALIZADO</span>
                        <span>${new Date(reserva.actualizado_en).toLocaleString('es-ES')}</span>
                    </div>
                    ` : ''}
                </div>
            </div>

            <div class="ticket-footer-modal">
                <p class="thank-you-modal">¡RESERVA CONFIRMADA EXITOSAMENTE!</p>
                <p class="website-modal">barberiaelite.com</p>
                <p class="timestamp-modal">${new Date(reserva.fecha).toLocaleDateString('es-ES')} ${reserva.hora}</p>
            </div>
        </div>
    `;
}

// Función simulada para obtener datos de reserva (deberías reemplazar esto con una petición AJAX real)
function getReservaData(reservaId) {
    // Esta es una simulación - en producción, deberías hacer una petición AJAX al servidor
    // para obtener los datos completos de la reserva
    return {
        id: reservaId,
        cliente: { nombre: 'Cliente Ejemplo' },
        barbero: { nombre: 'Barbero Ejemplo' },
        fecha: '2024-01-15',
        hora: '14:30',
        estado: 'pendiente',
        servicios: [
            { nombre: 'Corte de Cabello', precio: 150.00 },
            { nombre: 'Afeitado', precio: 80.00 }
        ],
        venta: null,
        metodo_pago: null,
        observaciones: 'Cliente prefiere corte clásico',
        creado_en: '2024-01-10 10:00:00',
        actualizado_en: '2024-01-10 10:00:00'
    };
}

// Event listeners cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function() {
    // Configurar botones de ver ticket
    document.querySelectorAll('.view-ticket-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const reservaId = this.getAttribute('data-reserva-id');
            showTicket(reservaId);
        });
    });

    // Configurar botón de descargar ticket
    document.getElementById('downloadTicketBtn').addEventListener('click', function() {
        const ticketElement = document.getElementById('ticketToDownload');
        if (ticketElement) {
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Generando...';
            this.disabled = true;
            
            html2canvas(ticketElement, {
                scale: 2,
                backgroundColor: '#FFFFFF',
                useCORS: true,
                logging: false
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = `reserva-${String(getCurrentReservaId()).padStart(4, '0')}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();
                
                this.innerHTML = originalText;
                this.disabled = false;
            }).catch(error => {
                console.error('Error al generar imagen:', error);
                alert('Error al generar la imagen del ticket');
                this.innerHTML = originalText;
                this.disabled = false;
            });
        }
    });

    // Auto-completar fechas para filtros rápidos
    const periodoSelect = document.querySelector('select[name="periodo"]');
    if (periodoSelect) {
        periodoSelect.addEventListener('change', function() {
            const hoy = new Date();
            const desde = document.getElementById('fechaDesde');
            const hasta = document.getElementById('fechaHasta');
            
            switch(this.value) {
                case 'hoy':
                    desde.value = hasta.value = hoy.toISOString().split('T')[0];
                    break;
                case '7':
                    const hace7Dias = new Date(hoy.getTime() - 7 * 24 * 60 * 60 * 1000);
                    desde.value = hace7Dias.toISOString().split('T')[0];
                    hasta.value = hoy.toISOString().split('T')[0];
                    break;
                case '15':
                    const hace15Dias = new Date(hoy.getTime() - 15 * 24 * 60 * 60 * 1000);
                    desde.value = hace15Dias.toISOString().split('T')[0];
                    hasta.value = hoy.toISOString().split('T')[0];
                    break;
                case '30':
                    const hace30Dias = new Date(hoy.getTime() - 30 * 24 * 60 * 60 * 1000);
                    desde.value = hace30Dias.toISOString().split('T')[0];
                    hasta.value = hoy.toISOString().split('T')[0];
                    break;
                case 'mes':
                    const primerDiaMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
                    const ultimoDiaMes = new Date(hoy.getFullYear(), hoy.getMonth() + 1, 0);
                    desde.value = primerDiaMes.toISOString().split('T')[0];
                    hasta.value = ultimoDiaMes.toISOString().split('T')[0];
                    break;
                case 'mes_pasado':
                    const primerDiaMesPasado = new Date(hoy.getFullYear(), hoy.getMonth() - 1, 1);
                    const ultimoDiaMesPasado = new Date(hoy.getFullYear(), hoy.getMonth(), 0);
                    desde.value = primerDiaMesPasado.toISOString().split('T')[0];
                    hasta.value = ultimoDiaMesPasado.toISOString().split('T')[0];
                    break;
            }
        });
    }

    // Efectos visuales para las tarjetas clickeables
    const clickableCards = document.querySelectorAll('.clickable-card');
    
    clickableCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
            this.style.cursor = 'pointer';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});

// Función auxiliar para obtener el ID de la reserva actual (simulada)
function getCurrentReservaId() {
    // En una implementación real, esto debería obtenerse del contexto
    return 1;
}
</script>
@stop

@section('css')
<style>
.metric-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.metric-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    cursor: pointer;
}

.clickable-card {
    cursor: pointer;
}

.active-metric {
    border-color: #fff !important;
    box-shadow: 0 0 0 3px rgba(255,255,255,0.5) !important;
    transform: translateY(-3px);
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.075);
}

/* ESTILOS PARA EL TICKET EN MODAL */
.ticket-container-modal {
    background: #FFFFFF;
    border: 2px solid #000000;
    border-radius: 8px;
    padding: 1.5rem;
    font-family: 'Courier New', monospace;
    font-size: 0.8rem;
    max-width: 100%;
    margin: 0 auto;
}

.ticket-header-modal {
    text-align: center;
    border-bottom: 2px dashed #000000;
    padding-bottom: 0.75rem;
    margin-bottom: 1rem;
}

.ticket-header-modal h1 {
    font-weight: 900;
    font-size: 1.4rem;
    margin: 0;
    color: #000000;
    letter-spacing: 1px;
}

.tagline-modal {
    font-size: 0.7rem;
    color: #4A4A4A;
    margin: 0.25rem 0 0 0;
    font-style: italic;
}

.ticket-section-modal {
    margin-bottom: 1rem;
}

.section-title-modal {
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    margin-bottom: 0.5rem;
    color: #000000;
    border-bottom: 1px solid #000000;
    padding-bottom: 0.2rem;
}

.section-content-modal {
    font-size: 0.7rem;
}

.ticket-row-modal {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.3rem;
}

.ticket-row-modal span:first-child {
    font-weight: 600;
}

.ticket-row-modal span:last-child {
    text-align: right;
}

.status-pendiente {
    color: #ffc107;
    font-weight: 700;
}

.status-realizada {
    color: #28a745;
    font-weight: 700;
}

.status-cancelada {
    color: #dc3545;
    font-weight: 700;
}

.status-no_asistio {
    color: #6c757d;
    font-weight: 700;
}

.items-table-modal {
    font-size: 0.65rem;
}

.table-header-modal, .table-row-modal {
    display: grid;
    grid-template-columns: 0.5fr 2fr 1fr;
    gap: 0.4rem;
    padding: 0.2rem 0;
}

.table-header-modal {
    font-weight: 700;
    border-bottom: 1px solid #000000;
    margin-bottom: 0.3rem;
}

.table-row-modal {
    border-bottom: 1px dashed #ccc;
}

.table-row-modal:last-child {
    border-bottom: none;
}

.total-row-modal {
    font-weight: 700;
    font-size: 0.75rem;
    border-top: 1px solid #000000;
    padding-top: 0.3rem;
    margin-top: 0.3rem;
}

.observations-modal {
    background: #F5F5DC;
    padding: 0.5rem;
    border-radius: 4px;
    border-left: 3px solid #D4AF37;
    font-style: italic;
    font-size: 0.65rem;
}

.ticket-footer-modal {
    text-align: center;
    border-top: 2px dashed #000000;
    padding-top: 0.75rem;
    margin-top: 1rem;
}

.thank-you-modal {
    font-weight: 700;
    font-size: 0.75rem;
    margin: 0 0 0.3rem 0;
    color: #000000;
}

.website-modal {
    font-size: 0.65rem;
    color: #4A4A4A;
    margin: 0 0 0.2rem 0;
}

.timestamp-modal {
    font-size: 0.6rem;
    color: #4A4A4A;
    margin: 0;
}

/* Mejoras para el modal */
.modal-content {
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    border-radius: 10px;
}

.modal-header {
    border-bottom: 2px solid #dee2e6;
    border-radius: 10px 10px 0 0 !important;
}

.modal-body .card {
    border: 1px solid #e3e6f0;
    border-radius: 8px;
}

.btn-close:focus {
    box-shadow: none;
}

/* Estilos para los badges de estado */
.badge.bg-warning { color: #000; }
.badge.bg-success { color: #fff; }
.badge.bg-danger { color: #fff; }
.badge.bg-dark { color: #fff; }

/* Responsive para el modal del ticket */
@media (max-width: 576px) {
    .ticket-container-modal {
        padding: 1rem;
    }
    
    .ticket-header-modal h1 {
        font-size: 1.2rem;
    }
    
    .table-header-modal, .table-row-modal {
        grid-template-columns: 0.6fr 1.8fr 1fr;
        gap: 0.2rem;
    }
}
</style>
@endsection