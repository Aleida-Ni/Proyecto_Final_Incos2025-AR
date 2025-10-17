<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('ventas')) {
            return;
        }

        if (! Schema::hasColumn('ventas', 'reserva_id')) {
            Schema::table('ventas', function (Blueprint $table) {
                $table->foreignId('reserva_id')->nullable()->after('id')->constrained('reservas')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        if (! Schema::hasTable('ventas') || ! Schema::hasColumn('ventas', 'reserva_id')) {
            return;
        }

        Schema::table('ventas', function (Blueprint $table) {
            try { $table->dropForeign(['reserva_id']); } catch (\Throwable $e) {}
            try { $table->dropColumn('reserva_id'); } catch (\Throwable $e) {}
        });
    }
};