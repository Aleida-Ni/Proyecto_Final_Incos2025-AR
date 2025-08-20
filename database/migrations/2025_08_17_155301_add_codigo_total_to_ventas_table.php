<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::table('ventas', function (Blueprint $table) {
        $table->string('codigo')->unique()->after('empleado_id');
        $table->decimal('total', 8, 2)->default(0)->after('codigo');
    });
}

public function down(): void
{
    Schema::table('ventas', function (Blueprint $table) {
        $table->dropColumn(['codigo', 'total']);
    });
}

};
