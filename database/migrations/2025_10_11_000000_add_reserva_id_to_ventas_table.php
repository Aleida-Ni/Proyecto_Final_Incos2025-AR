<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('ventas')) {
            if (! Schema::hasColumn('ventas', 'reserva_id')) {
                Schema::table('ventas', function (Blueprint $table) {
                    $table->unsignedBigInteger('reserva_id')->nullable()->after('empleado_id');
                });
            }

            // Ensure foreign key exists. We can't rely on Schema::hasColumn for FK, so try creating it
            // only if it's not already present in information_schema.
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = collect($sm->listTableForeignKeys('ventas'))->map->getColumns()->toArray();
            $fkExists = false;
            foreach ($sm->listTableForeignKeys('ventas') as $fk) {
                if (in_array('reserva_id', $fk->getColumns())) {
                    $fkExists = true;
                    break;
                }
            }

            if (! $fkExists) {
                Schema::table('ventas', function (Blueprint $table) {
                    $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('set null');
                });
            }
        }
    }

    public function down()
    {
        if (Schema::hasTable('ventas')) {
            // Drop foreign if exists
            try {
                Schema::table('ventas', function (Blueprint $table) {
                    $table->dropForeign(['reserva_id']);
                });
            } catch (\Exception $e) {
                // ignore: foreign key might not exist
            }

            if (Schema::hasColumn('ventas', 'reserva_id')) {
                Schema::table('ventas', function (Blueprint $table) {
                    $table->dropColumn('reserva_id');
                });
            }
        }
    }
};