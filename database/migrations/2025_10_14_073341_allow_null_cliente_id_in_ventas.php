<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Solo ejecutar si la tabla y la columna existen
        if (Schema::hasTable('ventas') && Schema::hasColumn('ventas', 'cliente_id')) {
            // Usar DB::statement para modificar directamente la columna
            try {
                DB::statement('ALTER TABLE ventas MODIFY cliente_id BIGINT UNSIGNED NULL');
            } catch (\Exception $e) {
                // Si falla por Doctrine/compatibilidad, ignoramos para no romper migraciones en DB existentes
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('ventas') && Schema::hasColumn('ventas', 'cliente_id')) {
            try {
                DB::statement('ALTER TABLE ventas MODIFY cliente_id BIGINT UNSIGNED NOT NULL');
            } catch (\Exception $e) {
                // ignore
            }
        }
    }
};
