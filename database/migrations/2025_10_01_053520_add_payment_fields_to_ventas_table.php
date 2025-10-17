<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('ventas')) {
            return;
        }

        // Añadir columnas solo si no existen
        if (! Schema::hasColumn('ventas', 'estado')) {
            Schema::table('ventas', function (Blueprint $table) {
                $table->string('estado')->default('pendiente')->after('total');
            });
        }

        if (! Schema::hasColumn('ventas', 'metodo_pago')) {
            Schema::table('ventas', function (Blueprint $table) {
                $table->string('metodo_pago')->nullable()->after('estado');
            });
        }

        if (! Schema::hasColumn('ventas', 'referencia')) {
            Schema::table('ventas', function (Blueprint $table) {
                $table->string('referencia')->nullable()->after('metodo_pago');
            });
            // crear índice único en referencia si no existe
            try {
                Schema::table('ventas', function (Blueprint $table) {
                    $table->unique('referencia');
                });
            } catch (\Throwable $e) {
                // ignorar si el índice ya existe o la DB no lo soporta
            }
        }

        if (! Schema::hasColumn('ventas', 'qr_path')) {
            Schema::table('ventas', function (Blueprint $table) {
                $table->string('qr_path')->nullable()->after('referencia');
            });
        }

        if (! Schema::hasColumn('ventas', 'comprobante_pago')) {
            Schema::table('ventas', function (Blueprint $table) {
                $table->string('comprobante_pago')->nullable()->after('qr_path');
            });
        }

        if (! Schema::hasColumn('ventas', 'pago_confirmado_at')) {
            Schema::table('ventas', function (Blueprint $table) {
                $table->timestamp('pago_confirmado_at')->nullable()->after('comprobante_pago');
            });
        }

        // índice para consultas por estado (intentar añadir si no existe)
        try {
            Schema::table('ventas', function (Blueprint $table) {
                $table->index('estado');
            });
        } catch (\Throwable $e) {
            // ignorar si ya existe
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('ventas')) {
            return;
        }

        // Eliminar índice si existe
        try { Schema::table('ventas', function (Blueprint $table) { $table->dropIndex(['estado']); }); } catch (\Throwable $e) {}

        // Dropear solo columnas que existan. NO tocar 'total'.
        $cols = ['estado','metodo_pago','referencia','qr_path','comprobante_pago','pago_confirmado_at'];
        $toDrop = [];
        foreach ($cols as $c) {
            if (Schema::hasColumn('ventas', $c)) {
                $toDrop[] = $c;
            }
        }

        if (! empty($toDrop)) {
            Schema::table('ventas', function (Blueprint $table) use ($toDrop) {
                $table->dropColumn($toDrop);
            });
        }
    }
};
