<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('reservas') && ! Schema::hasColumn('reservas', 'metodo_pago')) {
            Schema::table('reservas', function (Blueprint $table) {
                $table->enum('metodo_pago', ['efectivo', 'qr', 'transferencia'])
                      ->nullable()
                      ->after('estado');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('reservas') && Schema::hasColumn('reservas', 'metodo_pago')) {
            Schema::table('reservas', function (Blueprint $table) {
                $table->dropColumn('metodo_pago');
            });
        }
    }
};