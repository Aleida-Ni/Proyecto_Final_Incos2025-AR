<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $tableName = 'servicio_reserva';

        if (! Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->foreignId('reserva_id')->constrained('reservas')->onDelete('cascade');
                $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade');
                $table->decimal('precio', 8, 2)->nullable();
                $table->timestamp('creado_en')->nullable();
                $table->timestamp('actualizado_en')->nullable();
            });
            return;
        }

        // If table exists, perform safe repairs
        $database = DB::getDatabaseName();

        // 1) If primary key is composite (more than one column), drop it so id can be primary
        $pkCount = DB::selectOne(
            "SELECT COUNT(*) as c FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND CONSTRAINT_NAME = 'PRIMARY'",
            [$database, $tableName]
        )->c ?? 0;

        if ($pkCount > 1) {
            try {
                DB::statement("ALTER TABLE {$tableName} DROP PRIMARY KEY");
            } catch (\Throwable $e) {
                // ignore - we'll try to continue
            }
        }

        // 2) Ensure id column exists and is AUTO_INCREMENT
        $idCol = DB::selectOne(
            "SELECT COLUMN_NAME, EXTRA FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = 'id'",
            [$database, $tableName]
        );

        if (! $idCol) {
            // add id column as first column
            DB::statement("ALTER TABLE {$tableName} ADD COLUMN id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");
        } else {
            // if exists but not auto_increment, modify it
            $extra = $idCol->EXTRA ?? '';
            if (stripos($extra, 'auto_increment') === false) {
                // try to modify column to be auto increment and primary
                try {
                    DB::statement("ALTER TABLE {$tableName} MODIFY COLUMN id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT");
                    // ensure primary key on id
                    DB::statement("ALTER TABLE {$tableName} ADD PRIMARY KEY (id)");
                } catch (\Throwable $e) {
                    // ignore errors - if it fails, try to add primary key separately
                }
            }
        }

        // 3) Ensure timestamp columns named creado_en/actualizado_en exist; if created_at exists, rename it
        $hasCreado = Schema::hasColumn($tableName, 'creado_en');
        $hasActualizado = Schema::hasColumn($tableName, 'actualizado_en');

        if (! $hasCreado && Schema::hasColumn($tableName, 'created_at')) {
            DB::statement("ALTER TABLE {$tableName} CHANGE `created_at` `creado_en` TIMESTAMP NULL");
        }

        if (! $hasActualizado && Schema::hasColumn($tableName, 'updated_at')) {
            DB::statement("ALTER TABLE {$tableName} CHANGE `updated_at` `actualizado_en` TIMESTAMP NULL");
        }

        // 4) Add timestamps if neither pair exists
        if (! Schema::hasColumn($tableName, 'creado_en')) {
            DB::statement("ALTER TABLE {$tableName} ADD COLUMN `creado_en` TIMESTAMP NULL");
        }

        if (! Schema::hasColumn($tableName, 'actualizado_en')) {
            DB::statement("ALTER TABLE {$tableName} ADD COLUMN `actualizado_en` TIMESTAMP NULL");
        }

        // 5) Ensure reserva_id and servicio_id exist
        if (! Schema::hasColumn($tableName, 'reserva_id')) {
            DB::statement("ALTER TABLE {$tableName} ADD COLUMN reserva_id BIGINT UNSIGNED NULL");
        }

        if (! Schema::hasColumn($tableName, 'servicio_id')) {
            DB::statement("ALTER TABLE {$tableName} ADD COLUMN servicio_id BIGINT UNSIGNED NULL");
        }

        // 6) Ensure precio exists
        if (! Schema::hasColumn($tableName, 'precio')) {
            DB::statement("ALTER TABLE {$tableName} ADD COLUMN precio DECIMAL(8,2) NULL");
        }

        // 7) Try to add foreign keys if not present (may fail if constraints already exist)
        try {
            DB::statement("ALTER TABLE {$tableName} ADD CONSTRAINT fk_{$tableName}_reserva FOREIGN KEY (reserva_id) REFERENCES reservas(id) ON DELETE CASCADE");
        } catch (\Throwable $e) {
            // ignore
        }

        try {
            DB::statement("ALTER TABLE {$tableName} ADD CONSTRAINT fk_{$tableName}_servicio FOREIGN KEY (servicio_id) REFERENCES servicios(id) ON DELETE CASCADE");
        } catch (\Throwable $e) {
            // ignore
        }
    }

    public function down()
    {
        $tableName = 'servicio_reserva';
        if (Schema::hasTable($tableName)) {
            Schema::dropIfExists($tableName);
        }
    }
};
