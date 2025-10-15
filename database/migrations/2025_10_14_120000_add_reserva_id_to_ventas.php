<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            if (!Schema::hasColumn('ventas', 'reserva_id')) {
                $table->unsignedBigInteger('reserva_id')->nullable()->after('id');
                $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            if (Schema::hasColumn('ventas', 'reserva_id')) {
                $table->dropForeign([$table->getConnection()->getTablePrefix() . 'reserva_id']);
                $table->dropColumn('reserva_id');
            }
        });
    }
};
