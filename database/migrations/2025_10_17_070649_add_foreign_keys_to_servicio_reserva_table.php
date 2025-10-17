<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('servicio_reserva')) {
            return;
        }

        // Comprobar si las constraints ya existen
        $fkServicio = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='servicio_reserva' AND COLUMN_NAME='servicio_id' AND REFERENCED_TABLE_NAME='servicios'");
        $fkReserva = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='servicio_reserva' AND COLUMN_NAME='reserva_id' AND REFERENCED_TABLE_NAME='reservas'");

        if (empty($fkServicio)) {
            Schema::table('servicio_reserva', function (Blueprint $table) {
                $table->foreign('servicio_id')
                      ->references('id')
                      ->on('servicios')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');
            });
        }

        if (empty($fkReserva)) {
            Schema::table('servicio_reserva', function (Blueprint $table) {
                $table->foreign('reserva_id')
                      ->references('id')
                      ->on('reservas')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('servicio_reserva')) {
            return;
        }

        Schema::table('servicio_reserva', function (Blueprint $table) {
            try { $table->dropForeign(['servicio_id']); } catch (\Throwable $e) {}
            try { $table->dropForeign(['reserva_id']); } catch (\Throwable $e) {}
        });
    }
};
