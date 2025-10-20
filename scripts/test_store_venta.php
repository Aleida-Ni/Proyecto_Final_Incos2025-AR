<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\VentaController;
use App\Models\Producto;

// Encontrar un producto existente
$producto = Producto::first();
if (! $producto) {
    echo "No hay productos para probar.\n";
    exit(1);
}

// Simular datos de venta
$data = [
    'items' => [
        ['producto_id' => $producto->id, 'cantidad' => 1]
    ],
    'cliente_id' => null,
    'metodo_pago' => 'efectivo'
];

$request = Request::create('/admin/ventas', 'POST', $data);

$controller = new VentaController();
$response = $controller->store($request);

if (method_exists($response, 'getContent')) {
    echo $response->getContent() . "\n";
} else {
    print_r($response);
}
