@extends('adminlte::page')

@section('title', 'Dashboard - Barbería Elite')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-chart-line text-gold me-2"></i>Panel de Control</h1>
        <div class="text-muted">
            <small><i class="fas fa-calendar me-1"></i> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</small>
        </div>
    </div>
@stop

@section('content')
    <!-- MÉTRICAS PRINCIPALES -->
    <div class="row">
        <!-- Reservas Hoy -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $reservasHoy->count() ?? 8 }}</h3>
                    <p>Reservas Hoy</p>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-white" style="width: {{ min(($reservasHoy->count() ?? 8) * 10, 100) }}%"></div>
                    </div>
                    <small>{{ $reservasCompletadasHoy ?? 5 }} completadas</small>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <a href="{{ route('admin.reservas.index') }}" class="small-box-footer">
                    Ver reservas <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <!-- Ingresos del Mes -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>${{ number_format($ingresosMes ?? 12540, 2) }}</h3>
                    <p>Ingresos del Mes</p>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-white" style="width: {{ min((($ingresosMes ?? 12540) / 20000) * 100, 100) }}%"></div>
                    </div>
                    <small>+{{ $crecimientoIngresos ?? 12 }}% vs mes anterior</small>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <a href="{{ route('admin.reportes.ventas') }}" class="small-box-footer">
                    Ver reportes <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <!-- Clientes Activos -->
 
        
        <!-- Tasa de Asistencia -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $tasaAsistencia ?? 92 }}<sup style="font-size: 20px">%</sup></h3>
                    <p>Tasa de Asistencia</p>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-white" style="width: {{ $tasaAsistencia ?? 92 }}%"></div>
                    </div>
                    <small>{{ $cancelacionesMes ?? 8 }} cancelaciones</small>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <a href="{{ route('admin.reportes.reservas') }}" class="small-box-footer">
                    Ver estadísticas <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- SEGUNDA FILA DE MÉTRICAS -->
    <div class="row">
        <!-- Servicios Populares -->


        <!-- Barberos Activos -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-teal">
                <div class="inner">
                    <h3>{{ $barberosActivos ?? 4 }}</h3>
                    <p>Barberos Activos</p>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-white" style="width: {{ min((($barberosActivos ?? 4) / 6) * 100, 100) }}%"></div>
                    </div>
                    <small>{{ $barberosOcupados ?? 3 }} ocupados ahora</small>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <a href="{{ route('admin.barberos.index') }}" class="small-box-footer">
                    Ver barberos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Promedio Ticket -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-purple">
                <div class="inner">
                    <h3>${{ number_format($promedioTicket ?? 85.50, 2) }}</h3>
                    <p>Ticket Promedio</p>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-white" style="width: {{ min((($promedioTicket ?? 85.50) / 120) * 100, 100) }}%"></div>
                    </div>
                    <small>+${{ number_format($incrementoTicket ?? 5.20, 2) }} vs promedio</small>
                </div>
                <div class="icon">
                    <i class="fas fa-receipt"></i>
                </div>
                <a href="{{ route('admin.ventas.index') }}" class="small-box-footer">
                    Ver ventas <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Satisfacción Cliente -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-pink">
                <div class="inner">
                    <h3>{{ $satisfaccionClientes ?? 4.8 }}/5</h3>
                    <p>Satisfacción Cliente</p>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-white" style="width: {{ (($satisfaccionClientes ?? 4.8) / 5) * 100 }}%"></div>
                    </div>
                    <small>{{ $resenasMes ?? 34 }} reseñas este mes</small>
                </div>
                <div class="icon">
                    <i class="fas fa-star"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Ver reseñas <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- GRÁFICOS Y ESTADÍSTICAS -->
    <div class="row mt-4">
        <!-- Gráfico de Ingresos Mensuales -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-gradient-dark">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar me-2"></i>Ingresos de la Semana
                    </h3>
                    <div class="card-tools">
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option>Últimos 7 días</option>
                            <option>Este mes</option>
                            <option>Mes pasado</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="ingresosChart" style="min-height: 250px; height: 250px; max-height: 250px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reservas por Estado -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-gradient-info">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie me-2"></i>Reservas por Estado
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="reservasChart" style="min-height: 250px; height: 250px; max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLAS RÁPIDAS -->
    <div class="row mt-4">
        <!-- Próximas Reservas -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-gradient-success">
                    <h3 class="card-title">
                        <i class="fas fa-clock me-2"></i>Próximas Reservas
                    </h3>
                    <div class="card-tools">
                        <span class="badge bg-light text-dark">{{ $reservasHoy->count() ?? 5 }} hoy</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Cliente</th>
                                    <th>Hora</th>
                                    <th>Barbero</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservasHoy as $reserva)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/avatars/user-default.png') }}" 
                                                 class="img-circle img-size-32 mr-2" alt="User Image">
                                            <div>
                                                <strong>{{ $reserva->cliente->nombre ?? 'Cliente' }}</strong>
                                                <br><small class="text-muted">{{ $reserva->servicios->first()->nombre ?? 'Servicio' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $reserva->hora }}</strong>
                                        <br><small class="text-muted">{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $reserva->barbero->nombre ?? 'Barbero' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($reserva->estado == 'pendiente') bg-warning 
                                            @elseif($reserva->estado == 'realizada') bg-success 
                                            @elseif($reserva->estado == 'cancelada') bg-danger
                                            @elseif($reserva->estado == 'no_asistio') bg-dark
                                            @endif">
                                            {{ ucfirst($reserva->estado) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">
                                        <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                        <br>No hay reservas para hoy
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.reservas.index') }}" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-list me-1"></i>Ver todas las reservas
                    </a>
                </div>
            </div>
        </div>

        <!-- Servicios Más Populares -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-gradient-warning">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line me-2"></i>Servicios Más Populares
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Servicio</th>
                                    <th>Veces Solicitado</th>
                                    <th>Ingresos</th>
                                    <th>Tendencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($serviciosPopulares ?? [] as $servicio)
                                <tr>
                                    <td>
                                        <strong>{{ $servicio->nombre }}</strong>
                                        <br><small class="text-muted">{{ $servicio->duracion }} min</small>
                                    </td>
                                    <td>
                                        <strong>{{ $servicio->veces_solicitado }}</strong>
                                        <br><small class="text-muted">{{ $servicio->tasa_crecimiento }}%</small>
                                    </td>
                                    <td>
                                        <strong>${{ number_format($servicio->ingresos, 2) }}</strong>
                                    </td>
                                    <td>
                                        @if($servicio->tasa_crecimiento > 0)
                                        <span class="badge bg-success"><i class="fas fa-arrow-up"></i> ↑</span>
                                        @else
                                        <span class="badge bg-danger"><i class="fas fa-arrow-down"></i> ↓</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @if(!isset($serviciosPopulares))
                                <!-- Datos de ejemplo -->
                                <tr>
                                    <td>
                                        <strong>Corte Clásico</strong>
                                        <br><small class="text-muted">30 min</small>
                                    </td>
                                    <td>
                                        <strong>45</strong>
                                        <br><small class="text-muted">+12%</small>
                                    </td>
                                    <td><strong>$3,375.00</strong></td>
                                    <td><span class="badge bg-success"><i class="fas fa-arrow-up"></i> ↑</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Afeitado Tradicional</strong>
                                        <br><small class="text-muted">20 min</small>
                                    </td>
                                    <td>
                                        <strong>32</strong>
                                        <br><small class="text-muted">+5%</small>
                                    </td>
                                    <td><strong>$2,240.00</strong></td>
                                    <td><span class="badge bg-success"><i class="fas fa-arrow-up"></i> ↑</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Corte + Barba</strong>
                                        <br><small class="text-muted">45 min</small>
                                    </td>
                                    <td>
                                        <strong>28</strong>
                                        <br><small class="text-muted">+8%</small>
                                    </td>
                                    <td><strong>$2,520.00</strong></td>
                                    <td><span class="badge bg-success"><i class="fas fa-arrow-up"></i> ↑</span></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

@section('css')
<style>
:root {
    --color-dorado: #D4AF37;
    --color-gris-oscuro: #2C2C2C;
    --color-beige: #F5F5DC;
}

.small-box {
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border: none;
    position: relative;
    overflow: hidden;
}

.small-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.small-box .icon {
    transition: all 0.3s ease;
}

.small-box:hover .icon {
    transform: scale(1.1);
}

.small-box .inner h3 {
    font-weight: 700;
    margin-bottom: 5px;
}

.small-box .inner p {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 10px;
}

.small-box .inner small {
    opacity: 0.9;
    font-size: 0.85rem;
}

.small-box .progress {
    background: rgba(255,255,255,0.3);
    border-radius: 10px;
}

.small-box .progress-bar {
    border-radius: 10px;
}

.bg-gradient-indigo {
    background: linear-gradient(45deg, #6610f2, #6f42c1) !important;
    color: white;
}

.bg-gradient-teal {
    background: linear-gradient(45deg, #20c997, #3abaf4) !important;
    color: white;
}

.bg-gradient-purple {
    background: linear-gradient(45deg, #6f42c1, #e83e8c) !important;
    color: white;
}

.bg-gradient-pink {
    background: linear-gradient(45deg, #e83e8c, #fd7e14) !important;
    color: white;
}

.bg-gradient-dark {
    background: linear-gradient(45deg, var(--color-gris-oscuro), #495057) !important;
    color: white;
}

.bg-gradient-success {
    background: linear-gradient(45deg, #28a745, #20c997) !important;
    color: white;
}

.bg-gradient-warning {
    background: linear-gradient(45deg, #ffc107, #fd7e14) !important;
    color: white;
}

.bg-gradient-info {
    background: linear-gradient(45deg, #17a2b8, #6f42c1) !important;
    color: white;
}

.card {
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    border-radius: 10px;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
    border-bottom: none;
    font-weight: 600;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: var(--color-gris-oscuro);
}

.img-size-32 {
    width: 32px;
    height: 32px;
}

.badge {
    font-weight: 500;
}

.text-gold {
    color: var(--color-dorado) !important;
}

/* Animaciones suaves */
.small-box, .card {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de Ingresos de la Semana
    const ingresosCtx = document.getElementById('ingresosChart').getContext('2d');
    const ingresosChart = new Chart(ingresosCtx, {
        type: 'bar',
        data: {
            labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
            datasets: [{
                label: 'Ingresos ($)',
                data: [1800, 2200, 1900, 2500, 3000, 2800, 3200],
                backgroundColor: [
                    'rgba(212, 175, 55, 0.8)',
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(212, 175, 55, 0.8)',
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(212, 175, 55, 0.8)',
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(40, 167, 69, 0.8)'
                ],
                borderColor: [
                    'rgb(212, 175, 55)',
                    'rgb(40, 167, 69)',
                    'rgb(212, 175, 55)',
                    'rgb(40, 167, 69)',
                    'rgb(212, 175, 55)',
                    'rgb(40, 167, 69)',
                    'rgb(40, 167, 69)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `$${context.parsed.y.toLocaleString()}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Gráfico de Reservas por Estado
    const reservasCtx = document.getElementById('reservasChart').getContext('2d');
    const reservasChart = new Chart(reservasCtx, {
        type: 'doughnut',
        data: {
            labels: ['Completadas', 'Pendientes', 'Canceladas', 'No Asistió'],
            datasets: [{
                data: [65, 15, 12, 8],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(220, 53, 69, 0.8)',
                    'rgba(108, 117, 125, 0.8)'
                ],
                borderColor: [
                    'rgb(40, 167, 69)',
                    'rgb(255, 193, 7)',
                    'rgb(220, 53, 69)',
                    'rgb(108, 117, 125)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@stop