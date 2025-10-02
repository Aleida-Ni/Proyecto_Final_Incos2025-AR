<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->string('estado')->default('pendiente')->after('empleado_id'); // pendiente, en_revision, pagado, cancelado
            $table->string('qr')->nullable()->after('estado'); // ruta al PNG en storage/public/qrcodes/...
            $table->string('comprobante')->nullable()->after('qr'); // ruta a imagen/pdf subido por cliente
            $table->string('metodo_pago')->nullable()->after('comprobante'); // ejemplo: 'transferencia', 'efectivo'
            $table->string('referencia_pago')->nullable()->after('metodo_pago'); // referencia que ingrese admin
            $table->timestamp('fecha_pago')->nullable()->after('referencia_pago');
            $table->timestamp('procesado_en')->nullable()->after('fecha_pago');
        });
    }

    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropColumn([
                'estado','qr','comprobante','metodo_pago','referencia_pago','fecha_pago','procesado_en'
            ]);
        });
    }
};
