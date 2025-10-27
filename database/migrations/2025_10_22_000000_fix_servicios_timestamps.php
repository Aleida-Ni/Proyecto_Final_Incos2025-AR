<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * - If `creado_en`/`actualizado_en` do not exist and `created_at`/`updated_at` do, rename them.
     * - If both sets exist, copy values from english to spanish where spanish is null, then drop english columns.
     * This migration is idempotent and safe to run multiple times.
     */
    public function up()
    {
        // Table to fix
        $table = 'servicios';

        // Helper to check column existence
        $has = function($col) use ($table) {
            return Schema::hasColumn($table, $col);
        };

        // 1) If creado_en missing and created_at exists -> create creado_en, copy values and drop created_at
        if (! $has('creado_en') && $has('created_at')) {
            Schema::table($table, function (Blueprint $t) {
                $t->timestamp('creado_en')->nullable();
            });

            DB::table($table)
                ->whereNull('creado_en')
                ->whereNotNull('created_at')
                ->update(['creado_en' => DB::raw('created_at')]);

            Schema::table($table, function (Blueprint $t) use ($table) {
                if (Schema::hasColumn($table, 'created_at')) {
                    $t->dropColumn('created_at');
                }
            });
        }

        // 2) If actualizado_en missing and updated_at exists -> create actualizado_en, copy values and drop updated_at
        if (! $has('actualizado_en') && $has('updated_at')) {
            Schema::table($table, function (Blueprint $t) {
                $t->timestamp('actualizado_en')->nullable();
            });

            DB::table($table)
                ->whereNull('actualizado_en')
                ->whereNotNull('updated_at')
                ->update(['actualizado_en' => DB::raw('updated_at')]);

            Schema::table($table, function (Blueprint $t) use ($table) {
                if (Schema::hasColumn($table, 'updated_at')) {
                    $t->dropColumn('updated_at');
                }
            });
        }

        // 3) If both english and spanish exist (edge case), copy english -> spanish where spanish null and drop english
        if ($has('created_at') && $has('creado_en')) {
            DB::table($table)
                ->whereNull('creado_en')
                ->whereNotNull('created_at')
                ->update(['creado_en' => DB::raw('created_at')]);

            Schema::table($table, function (Blueprint $t) use ($table) {
                if (Schema::hasColumn($table, 'created_at')) {
                    $t->dropColumn('created_at');
                }
            });
        }

        if ($has('updated_at') && $has('actualizado_en')) {
            DB::table($table)
                ->whereNull('actualizado_en')
                ->whereNotNull('updated_at')
                ->update(['actualizado_en' => DB::raw('updated_at')]);

            Schema::table($table, function (Blueprint $t) use ($table) {
                if (Schema::hasColumn($table, 'updated_at')) {
                    $t->dropColumn('updated_at');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     * We will attempt to re-create english columns if missing and copy spanish values back.
     */
    public function down()
    {
        $table = 'servicios';

        if (! Schema::hasColumn($table, 'created_at')) {
            Schema::table($table, function (Blueprint $table) {
                $table->timestamp('created_at')->nullable();
            });
            DB::table($table)
                ->whereNull('created_at')
                ->whereNotNull('creado_en')
                ->update(['created_at' => DB::raw('creado_en')]);
        }

        if (! Schema::hasColumn($table, 'updated_at')) {
            Schema::table($table, function (Blueprint $table) {
                $table->timestamp('updated_at')->nullable();
            });
            DB::table($table)
                ->whereNull('updated_at')
                ->whereNotNull('actualizado_en')
                ->update(['updated_at' => DB::raw('actualizado_en')]);
        }

        // Optionally drop spanish columns if desired (not doing by default to avoid data loss)
    }
};