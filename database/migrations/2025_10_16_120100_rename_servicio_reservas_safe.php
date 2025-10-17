<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Si no existe la tabla antigua, nada que hacer
        if (! Schema::hasTable('servicio_reservas')) {
            return;
        }

        // Si ya existe la tabla destino, no hacemos rename
        if (Schema::hasTable('servicio_reserva')) {
            return;
        }

        // Asegurarnos de que la tabla antigua está vacía (para evitar pérdida de datos)
        $count = DB::table('servicio_reservas')->count();
        if ($count === 0) {
            Schema::rename('servicio_reservas', 'servicio_reserva');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('servicio_reserva') && ! Schema::hasTable('servicio_reservas')) {
            // Si la tabla fue renombrada y está vacía o coincide con el antiguo uso, renombrar de vuelta
            Schema::rename('servicio_reserva', 'servicio_reservas');
        }
    }
};
