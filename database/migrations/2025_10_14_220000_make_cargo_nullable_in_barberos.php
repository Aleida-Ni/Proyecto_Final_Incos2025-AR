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
        Schema::table('barberos', function (Blueprint $table) {
            if (Schema::hasColumn('barberos', 'cargo')) {
                // use change() requires doctrine/dbal; if not available, use raw SQL fallback
                try {
                    $table->string('cargo')->nullable()->change();
                } catch (\Throwable $e) {
                    // Fallback for environments without doctrine/dbal
                    DB::statement("ALTER TABLE `barberos` MODIFY `cargo` varchar(255) NULL");
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barberos', function (Blueprint $table) {
            if (Schema::hasColumn('barberos', 'cargo')) {
                try {
                    $table->string('cargo')->nullable(false)->change();
                } catch (\Throwable $e) {
                    DB::statement("ALTER TABLE `barberos` MODIFY `cargo` varchar(255) NOT NULL");
                }
            }
        });
    }
};
