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
    // Añadir la columna 'estado' de forma segura:
    if (Schema::hasTable('users')) {
        if (! Schema::hasColumn('users', 'estado')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('estado')->default(0)->after('rol');
            });
        }
        return;
    }

    // Si la app usa 'usuarios' como tabla principal, aplicar ahí
    if (Schema::hasTable('usuarios')) {
        if (! Schema::hasColumn('usuarios', 'estado')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->boolean('estado')->default(0)->after('rol');
            });
        }
        return;
    }
}

public function down()
{
    if (Schema::hasTable('users') && Schema::hasColumn('users', 'estado')) {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
        return;
    }

    if (Schema::hasTable('usuarios') && Schema::hasColumn('usuarios', 'estado')) {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
}

};
