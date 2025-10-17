<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Solo proceder si la tabla existe
        if (! Schema::hasTable('servicio_reserva')) {
            return;
        }

        // Asegurar engine InnoDB (necesario para FKs)
        $row = DB::select("SHOW TABLE STATUS WHERE Name = 'servicio_reserva'");
        if (! empty($row) && isset($row[0]->Engine) && strtoupper($row[0]->Engine) !== 'INNODB') {
            DB::statement("ALTER TABLE `servicio_reserva` ENGINE = InnoDB");
        }

        // Añadir columnas si faltan (servicio_id / reserva_id)
        Schema::table('servicio_reserva', function (Blueprint $table) {
            if (! Schema::hasColumn('servicio_reserva', 'servicio_id')) {
                $table->unsignedBigInteger('servicio_id')->nullable();
            }
            if (! Schema::hasColumn('servicio_reserva', 'reserva_id')) {
                $table->unsignedBigInteger('reserva_id')->nullable();
            }
        });

        // Crear FKs solo si no existen
        $constraints = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='servicio_reserva' AND CONSTRAINT_TYPE='FOREIGN KEY'");
        $existing = array_map(fn($r) => $r->CONSTRAINT_NAME, $constraints);

        Schema::table('servicio_reserva', function (Blueprint $table) use ($existing) {
            // Nombre amigable de constraint si no existe
            if (! in_array('servicio_reserva_servicio_id_foreign', $existing)) {
                $table->foreign('servicio_id', 'servicio_reserva_servicio_id_foreign')
                      ->references('id')
                      ->on('servicios')
                      ->onDelete('cascade');
            }

            if (! in_array('servicio_reserva_reserva_id_foreign', $existing)) {
                $table->foreign('reserva_id', 'servicio_reserva_reserva_id_foreign')
                      ->references('id')
                      ->on('reservas')
                      ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('servicio_reserva')) {
            return;
        }

        Schema::table('servicio_reserva', function (Blueprint $table) {
            // Intentar dropear las FKs si existen (ignorando errores)
            try { $table->dropForeign('servicio_reserva_servicio_id_foreign'); } catch (\Throwable $e) {}
            try { $table->dropForeign('servicio_reserva_reserva_id_foreign'); } catch (\Throwable $e) {}
        });
    }
};
