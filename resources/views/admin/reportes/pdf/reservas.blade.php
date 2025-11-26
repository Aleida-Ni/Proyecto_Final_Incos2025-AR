<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Reservas</title>
    <style>
        @page { margin: 20mm }
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color: #000; font-size: 12px; }
        .container { width: 100%; margin: 0 auto; }
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand img { height: 48px; filter: grayscale(100%); }
        .brand h2 { margin: 0; font-size: 18px; color: #000; }
        .meta { text-align: right; font-size: 11px; color: #222; }
        .stats { display: flex; gap: 12px; margin-top: 12px; margin-bottom: 14px; }
        .stat { background: #ffffff; padding: 8px 12px; border-radius: 6px; flex: 1; border: 1px solid #e6e9ee; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #d1d5db; padding: 8px; vertical-align: top; }
        th { background: #f7fafc; font-weight: 600; font-size: 11px; color: #000; }
        td { font-size: 11px; color: #111; }
        .right { text-align: right; }
        .small { font-size: 10px; color: #444; }
        .footer { position: fixed; bottom: 10mm; left: 0; right: 0; text-align: center; font-size: 10px; color: #444; }
        .estado { padding: 3px 6px; border-radius: 3px; font-weight: 600; font-size: 10px; background: #f3f4f6; color: #111; border: 1px solid #e6e9ee; }
        .pendiente { background: #ffffff; color: #111; }
        .realizada { background: #ffffff; color: #111; }
        .cancelada { background: #ffffff; color: #111; }
        .no-asistio { background: #ffffff; color: #111; }
    </style>
</head>
<body>
    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div class="brand">
                @if(file_exists(public_path('images/logo.png')))
                    <img src="{{ public_path('images/logo.png') }}" alt="Logo">
                @endif
                <h2>BarberShop — Reporte de Reservas</h2>
            </div>
            <div class="meta">
                <div>Período: <strong>{{ $fechaInicio }} - {{ $fechaFin }}</strong></div>
                <div>Generado: {{ now()->format('d/m/Y H:i:s') }}</div>
            </div>
        </div>

        <div class="stats">
            <div class="stat">
                <div class="small">Total Reservas</div>
                <div><strong>{{ $estadisticas['total'] }}</strong></div>
            </div>
            <div class="stat">
                <div class="small">Pendientes</div>
                <div><strong>{{ $estadisticas['pendientes'] }}</strong></div>
            </div>
            <div class="stat">
                <div class="small">Realizadas</div>
                <div><strong>{{ $estadisticas['realizadas'] }}</strong></div>
            </div>
            <div class="stat">
                <div class="small">Ingreso Total</div>
                <div><strong>Bs. {{ number_format($estadisticas['ingreso_total'], 2) }}</strong></div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th style="width:120px">Barbero</th>
                    <th style="width:90px">Fecha</th>
                    <th style="width:60px">Hora</th>
                    <th style="width:90px">Estado</th>
                    <th>Servicios</th>
                    <th style="width:90px" class="right">Total</th>
                </tr>
            </thead>
            <tbody>
                @php $totalPdf = 0; @endphp
                @foreach($reservas as $r)
                <tr>
                    <td>{{ optional($r->cliente)->nombre ?? 'Cliente' }}</td>
                    <td>{{ optional($r->barbero)->nombre ?? '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $r->hora }}</td>
                    <td><span class="estado {{ $r->estado }}">{{ ucfirst($r->estado) }}</span></td>
                    <td>{{ $r->servicios->map(fn($s) => optional($s->servicio)->nombre ?? $s->nombre)->join(', ') }}</td>
                    @php $fila = $r->venta ? $r->venta->total : ($r->servicios->sum('precio') ?? 0); $totalPdf += $fila; @endphp
                    <td class="right">Bs. {{ number_format($fila, 2) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="6" style="text-align:right"><strong>Total listado:</strong></td>
                    <td class="right"><strong>Bs. {{ number_format($totalPdf, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <div>© {{ date('Y') }} BarberShop — Todos los derechos reservados</div>
    </div>
</body>
</html>