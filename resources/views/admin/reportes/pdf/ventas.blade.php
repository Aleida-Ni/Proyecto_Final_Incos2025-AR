<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Ventas</title>
    <style>
        /* Estilos compatibles con DomPDF */
        @page { margin: 20mm }
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color: #000; font-size: 12px; }
        .container { width: 100%; margin: 0 auto; }
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand img { height: 48px; filter: grayscale(100%); }
        .brand h2 { margin: 0; font-size: 18px; color: #000; }
        .meta { text-align: right; font-size: 11px; color: #222; }
        .metrics { display: flex; gap: 12px; margin-top: 12px; margin-bottom: 14px; }
        .metric { background: #ffffff; padding: 8px 12px; border-radius: 6px; flex: 1; border: 1px solid #e6e9ee; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #d1d5db; padding: 8px; vertical-align: top; }
        th { background: #f7fafc; font-weight: 600; font-size: 11px; color: #000; }
        td { font-size: 11px; color: #111; }
        .right { text-align: right; }
        .small { font-size: 10px; color: #444; }
        .footer { position: fixed; bottom: 10mm; left: 0; right: 0; text-align: center; font-size: 10px; color: #444; }
    </style>
</head>
<body>
    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div class="brand">
                @if(file_exists(public_path('images/logo.png')))
                    <img src="{{ public_path('images/logo.png') }}" alt="Logo">
                @endif
                <h2>BarberShop — Reporte de Ventas</h2>
            </div>
            <div class="meta">
                <div>Período: <strong>{{ $fechaInicio }} - {{ $fechaFin }}</strong></div>
                <div>Generado: {{ now()->format('d/m/Y H:i:s') }}</div>
            </div>
        </div>

        <div class="metrics">
            <div class="metric">
                <div class="small">Total Ventas</div>
                <div><strong>{{ $stats['total_ventas'] }}</strong></div>
            </div>
            <div class="metric">
                <div class="small">Ingresos Totales</div>
                <div><strong>Bs. {{ number_format($stats['ingreso_total'], 2) }}</strong></div>
            </div>
            <div class="metric">
                <div class="small">Promedio por Venta</div>
                <div><strong>Bs. {{ number_format($stats['promedio_venta'], 2) }}</strong></div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width:80px">Código</th>
                    <th style="width:90px">Fecha</th>
                    <th>Cliente / Empleado</th>
                    <th>Productos</th>
                    <th style="width:80px">Pago</th>
                    <th style="width:90px" class="right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                <tr>
                    <td>{{ $venta->codigo }}</td>
                    <td>{{ $venta->creado_en->format('d/m/Y H:i') }}</td>
                    <td>
                        <strong>{{ $venta->cliente->nombre ?? 'Cliente no registrado' }}</strong>
                        <div class="small">Atendido por: {{ $venta->empleado->nombre ?? 'N/A' }}</div>
                    </td>
                    <td>
                        @foreach($venta->detalles as $detalle)
                            <div style="margin-bottom:6px;">
                                <strong>{{ $detalle->producto->nombre }}</strong>
                                <div class="small">{{ $detalle->cantidad }} x Bs. {{ number_format($detalle->precio_unitario, 2) }}</div>
                            </div>
                        @endforeach
                    </td>
                    <td class="small">{{ ucfirst($venta->metodo_pago) }}</td>
                    <td class="right"><strong>Bs. {{ number_format($venta->total, 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="right">TOTAL</th>
                    <th class="right">Bs. {{ number_format($stats['ingreso_total'], 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="footer">
        <div>© {{ date('Y') }} BarberShop — Todos los derechos reservados</div>
    </div>
</body>
</html>