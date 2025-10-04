<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ventas', function (Blueprint $table) {

            // estado: pendiente, por_revision, pagado, rechazado, cancelado
            $table->string('estado')->default('pendiente')->after('total');

            // metodo de pago (transferencia, efectivo, tarjeta, etc.)
            $table->string('metodo_pago')->nullable()->after('estado');

            // referencia única para el pago (puede usarse en QR)
            $table->string('referencia')->nullable()->unique()->after('metodo_pago');

            // ruta de la imagen QR en storage (public disk)
            $table->string('qr_path')->nullable()->after('referencia');

            // ruta del comprobante subido por el cliente (imagen/pdf)
            $table->string('comprobante_pago')->nullable()->after('qr_path');

            // fecha/hora cuando se confirma el pago (llena cuando admin marca pagado)
            $table->timestamp('pago_confirmado_at')->nullable()->after('comprobante_pago');

            // índice para consultas por estado
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropIndex(['estado']);
            $table->dropColumn([
                'total',
                'estado',
                'metodo_pago',
                'referencia',
                'qr_path',
                'comprobante_pago',
                'pago_confirmado_at'
            ]);
        });
    }
};
