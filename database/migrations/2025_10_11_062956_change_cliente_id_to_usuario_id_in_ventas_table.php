<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('ventas', function (Blueprint $table) {
        $table->renameColumn('cliente_id', 'usuario_id');
    });
}

public function down()
{
    Schema::table('ventas', function (Blueprint $table) {
        $table->renameColumn('usuario_id', 'cliente_id');
    });
}
};
