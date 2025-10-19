<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;

$controller = new RegisterController();

$requestData = [
    'nombre' => 'I sa C',
    'apellido_paterno' => 'Gomez',
    'apellido_materno' => 'Lopez',
    'correo' => 'isac_test@example.com',
    'telefono' => '12345678',
    'fecha_nacimiento' => '1990-01-01',
    'contrasenia' => 'password123',
    'contrasenia_confirmation' => 'password123'
];

$request = Request::create('/register', 'POST', $requestData);

try {
    $response = $controller->register($request);
    echo "Controller returned response of type: " . gettype($response) . "\n";
} catch (\Illuminate\Validation\ValidationException $e) {
    echo "Validation failed:\n";
    print_r($e->validator->errors()->all());
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Check if user created
use App\Models\Usuario;
$u = Usuario::where('correo', strtolower(trim($requestData['correo'])))->first();
if ($u) {
    echo "Usuario creado: " . $u->nombre . "\n";
} else {
    echo "Usuario NO creado\n";
}
