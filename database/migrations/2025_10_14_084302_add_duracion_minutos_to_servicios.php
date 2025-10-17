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

        if (! Schema::hasColumn('servicios', 'duracion_minutos')) {
            Schema::table('servicios', function (Blueprint $table) {
                $table->integer('duracion_minutos')->after('precio')->default(30);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('servicios') || ! Schema::hasColumn('servicios', 'duracion_minutos')) {
            return;
        }

        Schema::table('servicios', function (Blueprint $table) {
            try { $table->dropColumn('duracion_minutos'); } catch (\Throwable $e) {}
        });
    }
};
