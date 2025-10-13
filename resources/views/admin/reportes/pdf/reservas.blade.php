<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Reservas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2563eb;
            margin: 0;
        }
        .header p {
            color: #64748b;
            margin: 5px 0;
        }
        .stats {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
        }
        .stat {
            text-align: center;
            width: 25%;
            margin-bottom: 15px;
        }
        .stat h3 {
            color: #1e40af;
            margin: 0;
        }
        .stat p {
            color: #64748b;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f1f5f9;
            color: #1e293b;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
        }
        .estado {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
        }
        .pendiente { background: #fef3c7; color: #92400e; }
        .realizada { background: #dcfce7; color: #166534; }
        .cancelada { background: #fee2e2; color: #991b1b; }
        .no-asistio { background: #f3f4f6; color: #1f2937; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Reservas</h1>
        <p>Período: {{ $fechaInicio }} - {{ $fechaFin }}</p>
        <p>Generado el: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="stats">
        <div class="stat">
            <h3>{{ $estadisticas['total'] }}</h3>
            <p>Total Reservas</p>
        </div>
        <div class="stat">
            <h3>{{ $estadisticas['pendientes'] }}</h3>
            <p>Pendientes</p>
        </div>
        <div class="stat">
            <h3>{{ $estadisticas['realizadas'] }}</h3>
            <p>Realizadas</p>
        </div>
        <div class="stat">
            <h3>{{ $estadisticas['canceladas'] }}</h3>
            <p>Canceladas</p>
        </div>
        <div class="stat">
            <h3>{{ $estadisticas['no_asistio'] }}</h3>
            <p>No Asistió</p>
        </div>
        <div class="stat">
            <h3>{{ $estadisticas['tasa_asistencia'] }}%</h3>
            <p>Tasa Asistencia</p>
        </div>
        <div class="stat">
            <h3>Bs. {{ number_format($estadisticas['ingreso_total'], 2) }}</h3>
            <p>Ingreso Total</p>
        </div>
        <div class="stat">
            <h3>Bs. {{ number_format($estadisticas['promedio_reserva'], 2) }}</h3>
            <p>Promedio por Reserva</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Barbero</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <th>Servicios</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservas as $r)
            <tr>
                <td>#{{ $r->id }}</td>
                <td>{{ optional($r->cliente)->nombre ?? 'Cliente' }}</td>
                <td>{{ optional($r->barbero)->nombre ?? '—' }}</td>
                <td>{{ \Carbon\Carbon::parse($r->fecha)->format('d/m/Y') }}</td>
                <td>{{ $r->hora }}</td>
                <td>
                    <span class="estado {{ $r->estado }}">
                        {{ ucfirst($r->estado) }}
                    </span>
                </td>
                <td>
                    {{ $r->servicios->pluck('nombre')->join(', ') }}
                </td>
                <td>
                    @php
                        $total = $r->venta ? $r->venta->total : $r->servicios->sum('pivot.precio');
                    @endphp
                    Bs. {{ number_format($total, 2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>© {{ date('Y') }} BarberShop - Todos los derechos reservados</p>
    </div>
</body>
</html>