<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;

$controller = new RegisterController();

$requestData = [
    'nombre' => '   Juan   Pablo   ',
    'apellido_paterno' => '  Pérez  ',
    'apellido_materno' => '  López  ',
    'correo' => ' TEST@EXAMPLE.COM ',
    'telefono' => ' 1234567 ',
    'fecha_nacimiento' => '1990-01-01',
    'contrasenia' => 'password123',
    'contrasenia_confirmation' => 'password123'
];

$request = Request::create('/register', 'POST', $requestData);

$response = $controller->register($request);

// Mostrar resultado simple
if (is_object($response)) {
    echo "Respuesta: ";
    if (method_exists($response, 'getStatusCode')) {
        echo "Status " . $response->getStatusCode() . "\n";
    }
}

// Verificar usuario creado
use App\Models\Usuario;
$u = Usuario::where('correo', strtolower(trim($requestData['correo'])))->first();
if ($u) {
    echo "Usuario creado: " . $u->nombre . "|" . $u->apellido_paterno . "|" . $u->apellido_materno . "\n";
} else {
    echo "Usuario no creado\n";
}
