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
        if (Schema::hasTable('detalles_venta') && ! Schema::hasColumn('detalles_venta', 'subtotal')) {
            Schema::table('detalles_venta', function (Blueprint $table) {
                $table->decimal('subtotal', 10, 2)->after('precio');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('detalles_venta') && Schema::hasColumn('detalles_venta', 'subtotal')) {
            Schema::table('detalles_venta', function (Blueprint $table) {
                $table->dropColumn('subtotal');
            });
        }
    }
};
