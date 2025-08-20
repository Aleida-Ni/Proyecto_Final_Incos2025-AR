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
    Schema::table('detalles_venta', function (Blueprint $table) {
        $table->decimal('subtotal', 10, 2)->after('precio');
    });
}

public function down()
{
    Schema::table('detalles_venta', function (Blueprint $table) {
        $table->dropColumn('subtotal');
    });
}

};
