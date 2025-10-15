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
        Schema::table('detalles_venta', function (Blueprint $table) {
            if (!Schema::hasColumn('detalles_venta', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->after('precio');
            }
            if (!Schema::hasColumn('detalles_venta', 'creado_en')) {
                $table->timestamp('creado_en')->nullable()->after('subtotal');
            }
            if (!Schema::hasColumn('detalles_venta', 'actualizado_en')) {
                $table->timestamp('actualizado_en')->nullable()->after('creado_en');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalles_venta', function (Blueprint $table) {
            if (Schema::hasColumn('detalles_venta', 'subtotal')) {
                $table->dropColumn('subtotal');
            }
            if (Schema::hasColumn('detalles_venta', 'creado_en')) {
                $table->dropColumn('creado_en');
            }
            if (Schema::hasColumn('detalles_venta', 'actualizado_en')) {
                $table->dropColumn('actualizado_en');
            }
        });
    }
};
