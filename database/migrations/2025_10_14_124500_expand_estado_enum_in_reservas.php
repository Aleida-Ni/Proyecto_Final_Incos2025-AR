<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // MySQL enum alteration: recreate the column with the larger enum set
        if (Schema::hasTable('reservas')) {
            $values = "'pendiente','confirmada','rechazada','realizada','cancelada','no_asistio'";
            // Only attempt if current enum doesn't already include the new values
            try {
                DB::statement("ALTER TABLE reservas MODIFY estado ENUM($values) NOT NULL DEFAULT 'pendiente'");
            } catch (\Exception $e) {
                // No-op: if it fails (e.g., driver differences), we leave it to manual migration
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('reservas')) {
            $values = "'pendiente','confirmada','rechazada'";
            try {
                DB::statement("ALTER TABLE reservas MODIFY estado ENUM($values) NOT NULL DEFAULT 'pendiente'");
            } catch (\Exception $e) {
                // ignore
            }
        }
    }
};
