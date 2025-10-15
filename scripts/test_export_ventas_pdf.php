<?php
// Script rápido para invocar exportarVentasPDF y capturar errores
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Crear request simulada
$request = Illuminate\Http\Request::create('/admin/reportes/ventas/pdf', 'GET');

$response = null;
try {
    $controller = new App\Http\Controllers\Admin\ReporteController();
    $response = $controller->exportarVentasPDF($request);
    echo "Export invoked successfully\n";
} catch (Throwable $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}

