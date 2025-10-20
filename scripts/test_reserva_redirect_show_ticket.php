<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\Cliente\ReservaController;
use App\Models\Barbero;
use App\Models\Usuario;

// Asegurar que hay un usuario y barbero
$user = Usuario::first();
$barbero = Barbero::first();
if(! $user || ! $barbero) {
    echo "Faltan datos (usuario o barbero).\n";
    exit(1);
}

// Simular autenticación (si la app usa auth guard)
\Illuminate\Support\Facades\Auth::login($user);

// Crear request de reserva
$request = Request::create('/cliente/reservar', 'POST', [
    'barbero_id' => $barbero->id,
    'fecha' => date('Y-m-d', strtotime('+1 day')),
    'hora' => '09:00'
]);

$controller = new ReservaController();
$response = $controller->store($request);

if($response instanceof \Illuminate\Http\RedirectResponse) {
    echo "Redirige a: " . $response->getTargetUrl() . "\n";
} else {
    echo "Respuesta inesperada:\n";
    print_r($response);
}
