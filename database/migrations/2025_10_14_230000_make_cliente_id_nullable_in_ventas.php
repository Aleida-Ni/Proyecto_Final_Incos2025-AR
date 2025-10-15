<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            if (Schema::hasColumn('ventas', 'cliente_id')) {
                try {
                    $table->unsignedBigInteger('cliente_id')->nullable()->change();
                } catch (\Throwable $e) {
                    // Fallback for environments without doctrine/dbal
                    DB::statement('ALTER TABLE `ventas` MODIFY `cliente_id` BIGINT UNSIGNED NULL');
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            if (Schema::hasColumn('ventas', 'cliente_id')) {
                try {
                    $table->unsignedBigInteger('cliente_id')->nullable(false)->change();
                } catch (\Throwable $e) {
                    DB::statement('ALTER TABLE `ventas` MODIFY `cliente_id` BIGINT UNSIGNED NOT NULL');
                }
            }
        });
    }
};
