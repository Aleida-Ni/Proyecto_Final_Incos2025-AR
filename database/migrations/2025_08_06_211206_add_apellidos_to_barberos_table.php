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
    Schema::table('barberos', function (Blueprint $table) {
        $table->string('apellido_paterno')->nullable()->after('nombre');
        $table->string('apellido_materno')->nullable()->after('apellido_paterno');
    });
}

public function down(): void
{
    Schema::table('barberos', function (Blueprint $table) {
        $table->dropColumn(['apellido_paterno', 'apellido_materno']);
    });
}

};
