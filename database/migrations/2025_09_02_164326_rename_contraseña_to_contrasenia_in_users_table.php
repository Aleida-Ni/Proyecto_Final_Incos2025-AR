<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
Schema::table('users', function (Blueprint $table) {
    $table->string('contraseña')->change(); // primero asegúrate que existe
    $table->renameColumn('contraseña', 'contrasenia');
});

    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('contrasenia', 'contraseña');
        });
    }
};

