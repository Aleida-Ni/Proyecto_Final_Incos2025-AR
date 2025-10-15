<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('servicios', function (Blueprint $table) {
            // Eliminar las columnas viejas si existen y renombrar las nuevas
            if (Schema::hasColumn('servicios', 'creado_en') && !Schema::hasColumn('servicios', 'created_at')) {
                $table->renameColumn('creado_en', 'created_at');
            }
            if (Schema::hasColumn('servicios', 'actualizado_en') && !Schema::hasColumn('servicios', 'updated_at')) {
                $table->renameColumn('actualizado_en', 'updated_at');
            }
        });
    }

    public function down()
    {
        Schema::table('servicios', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->timestamp('creado_en')->nullable();
            $table->timestamp('actualizado_en')->nullable();
        });
    }
};