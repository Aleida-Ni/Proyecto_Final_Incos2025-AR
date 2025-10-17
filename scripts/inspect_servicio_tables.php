<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$db = $app['db'];
$result = [];
$tables = $db->select("SHOW TABLES LIKE 'servicio%'");
$result['found_tables'] = $tables;
foreach ($tables as $row) {
    // the object key varies by MySQL version; get first property
    $vals = array_values((array)$row);
    $table = $vals[0];
    $result['tables'][$table] = [];
    try {
        $create = $db->select("SHOW CREATE TABLE `{$table}`");
        $result['tables'][$table]['create'] = $create;
    } catch (Throwable $e) {
        $result['tables'][$table]['create_error'] = $e->getMessage();
    }
    try {
        $count = $db->select("SELECT COUNT(*) as c FROM `{$table}`");
        $result['tables'][$table]['count'] = $count[0]->c ?? null;
    } catch (Throwable $e) {
        $result['tables'][$table]['count_error'] = $e->getMessage();
    }
}
echo json_encode($result, JSON_PRETTY_PRINT);
