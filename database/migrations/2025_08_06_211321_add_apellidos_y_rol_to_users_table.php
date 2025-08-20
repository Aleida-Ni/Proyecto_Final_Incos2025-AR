<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_add_apellidos_y_rol_to_users_table.php

public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('apellido_paterno')->nullable()->after('name');
        $table->string('apellido_materno')->nullable()->after('apellido_paterno');
        // No agregues la columna "rol", ya la tienes
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['apellido_paterno', 'apellido_materno']);
        // No borres rol
    });
}

};
