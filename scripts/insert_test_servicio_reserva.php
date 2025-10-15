<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    DB::table('servicio_reserva')->insert([
        'reserva_id' => 41,
        'servicio_id' => 2,
        'precio' => 25.00,
        'actualizado_en' => now(),
        'creado_en' => now(),
    ]);
    echo "Insert OK\n";
} catch (Exception $e) {
    echo "Insert failed: " . $e->getMessage() . "\n";
}
