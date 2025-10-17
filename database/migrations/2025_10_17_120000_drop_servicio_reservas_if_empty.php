<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('servicio_reservas')) {
            return;
        }

        try {
            $count = DB::table('servicio_reservas')->count();
        } catch (\Throwable $e) {
            return;
        }

        if ($count === 0) {
            Schema::dropIfExists('servicio_reservas');
        }
    }

    public function down()
    {
        // No recreamos la tabla automáticamente en down() porque era un remanente.
    }
};
