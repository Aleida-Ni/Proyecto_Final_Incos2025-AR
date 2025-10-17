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
        if (! Schema::hasTable('ventas')) {
            return;
        }

        // Añadir columna solo si no existe
        if (! Schema::hasColumn('ventas', 'reserva_id')) {
            Schema::table('ventas', function (Blueprint $table) {
                $table->unsignedBigInteger('reserva_id')->nullable()->after('id');
            });
        }

        // Añadir FK solo si no existe aún
        try {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $fkExists = false;
            foreach ($sm->listTableForeignKeys('ventas') as $fk) {
                if (in_array('reserva_id', $fk->getColumns())) {
                    $fkExists = true;
                    break;
                }
            }
            if (! $fkExists) {
                Schema::table('ventas', function (Blueprint $table) {
                    $table->foreign('reserva_id')
                          ->references('id')
                          ->on('reservas')
                          ->onDelete('set null');
                });
            }
        } catch (\Throwable $e) {
            // Si Doctrine no está disponible o falla, intentar añadir FK de forma segura
            try {
                Schema::table('ventas', function (Blueprint $table) {
                    $table->foreign('reserva_id')
                          ->references('id')
                          ->on('reservas')
                          ->onDelete('set null');
                });
            } catch (\Throwable $e) {
                // ignore
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
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
