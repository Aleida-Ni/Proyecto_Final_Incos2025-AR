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
        if (! Schema::hasTable('servicios')) {
            return;
        }

        if (! Schema::hasColumn('servicios', 'activo')) {
            Schema::table('servicios', function (Blueprint $table) {
                $table->boolean('activo')->default(true)->after('precio');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('servicios') || ! Schema::hasColumn('servicios', 'activo')) {
            return;
        }

        Schema::table('servicios', function (Blueprint $table) {
            try { $table->dropColumn('activo'); } catch (\Throwable $e) {}
        });
    }
};
