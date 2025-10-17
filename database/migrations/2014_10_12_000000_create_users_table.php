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
        if (! Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->string('apellido_paterno')->nullable();
                $table->string('apellido_materno')->nullable();
                $table->string('correo')->unique();
                $table->string('telefono')->nullable();
                $table->date('fecha_nacimiento')->nullable();
                $table->timestamp('correo_verificado_en')->nullable();
                $table->string('contrasenia');
                $table->string('rol')->default('cliente');
                $table->boolean('estado')->default(true);
                $table->string('remember_token')->nullable();
                $table->timestamp('creado_en')->nullable();
                $table->timestamp('actualizado_en')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
     public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }

};
