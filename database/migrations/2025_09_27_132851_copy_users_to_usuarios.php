<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    DB::statement("
        INSERT INTO usuarios (id, nombre, apellido_paterno, apellido_materno, correo, correo_verificado_en, contraseña, token_recordar, telefono, fecha_nacimiento, rol, estado, creado_en, actualizado_en)
        SELECT id, nombre, apellido_paterno, apellido_materno, correo, correo_verificado_en, contrasenia, token_recordar, telefono, fecha_nacimiento, rol, estado, creado_en, actualizado_en
        FROM users
    ");
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            //
        });
    }
};
