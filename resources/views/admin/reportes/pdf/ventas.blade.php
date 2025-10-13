<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Ventas</title>
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
        .metrics {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
        }
        .metric {
            text-align: center;
        }
        .metric h3 {
            color: #1e40af;
            margin: 0;
        }
        .metric p {
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
            font-size: 10px;
            vertical-align: top;
        }
        th {
            background-color: #f1f5f9;
            color: #1e293b;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        td strong {
            color: #1e293b;
            display: block;
            margin-bottom: 2px;
        }
        td small {
            color: #64748b;
            font-size: 9px;
        }
        .productos-lista {
            margin: 0;
            padding: 0;
        }
        .producto-item {
            margin-bottom: 4px;
            padding-bottom: 4px;
            border-bottom: 1px dotted #e2e8f0;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Ventas</h1>
        <p>Período: {{ $fechaInicio }} - {{ $fechaFin }}</p>
        <p>Generado el: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="metrics">
        <div class="metric">
            <h3>{{ $stats['total_ventas'] }}</h3>
            <p>Total Ventas</p>
        </div>
        <div class="metric">
            <h3>Bs. {{ number_format($stats['ingreso_total'], 2) }}</h3>
            <p>Ingresos Totales</p>
        </div>
        <div class="metric">
            <h3>Bs. {{ number_format($stats['promedio_venta'], 2) }}</h3>
            <p>Promedio por Venta</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Fecha</th>
                <th>Cliente/Empleado</th>
                <th>Productos</th>
                <th>Método Pago</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
            <tr>
                <td>{{ $venta->codigo }}</td>
                <td>{{ $venta->creado_en->format('d/m/Y H:i') }}</td>
                <td>
                    <strong>{{ $venta->cliente->nombre ?? 'Cliente no registrado' }}</strong><br>
                    <small>Atendido por: {{ $venta->empleado->nombre ?? 'N/A' }}</small>
                </td>
                <td>
                    @foreach($venta->detalles as $detalle)
                    - {{ $detalle->producto->nombre }}<br>
                    <small>({{ $detalle->cantidad }} x Bs. {{ number_format($detalle->precio_unitario, 2) }})</small><br>
                    @endforeach
                </td>
                <td>{{ ucfirst($venta->metodo_pago) }}</td>
                <td>Bs. {{ number_format($venta->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" style="text-align: right">TOTAL:</th>
                <th>Bs. {{ number_format($stats['ingreso_total'], 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>© {{ date('Y') }} BarberShop - Todos los derechos reservados</p>
    </div>
</body>
</html>