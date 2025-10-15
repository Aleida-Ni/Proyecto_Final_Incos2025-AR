<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\ReporteController;
use Illuminate\Http\Request;

class TestExportVentas extends Command
{
    protected $signature = 'test:export-ventas';
    protected $description = 'Invoca exportarVentasPDF para debug';

    public function handle()
    {
        $controller = new ReporteController();
        $request = Request::create('/admin/reportes/ventas/pdf', 'GET');

        try {
            $response = $controller->exportarVentasPDF($request);
            $this->info('Export invoked successfully.');
        } catch (\Throwable $e) {
            $this->error('Exception: ' . $e->getMessage());
            $this->line($e->getTraceAsString());
        }

        return 0;
    }
}
