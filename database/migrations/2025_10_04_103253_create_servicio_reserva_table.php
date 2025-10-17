<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Si ya existe la tabla, no hacemos nada
        if (Schema::hasTable('servicio_reserva')) {
            return;
        }

        // Si existe una tabla con nombre similar (legacy), no crear aquí para evitar duplicados.
        if (Schema::hasTable('servicio_reservas')) {
            // La normalización (rename) se realiza en una migración segura separada.
            return;
        }

        Schema::create('servicio_reserva', function (Blueprint $table) {
            // Asegurar motor InnoDB para soportar FKs
            $table->engine = 'InnoDB';
            $table->id();

            // Agregar columna reserva_id: si la tabla 'reservas' existe, añadir FK; sino añadir la columna simple
            if (Schema::hasTable('reservas')) {
                $table->foreignId('reserva_id')->constrained()->onDelete('cascade');
            } else {
                $table->unsignedBigInteger('reserva_id');
            }

            // Agregar columna servicio_id: si la tabla 'servicios' existe, añadir FK; sino añadir la columna simple
            if (Schema::hasTable('servicios')) {
                $table->foreignId('servicio_id')->constrained()->onDelete('cascade');
            } else {
                $table->unsignedBigInteger('servicio_id');
            }

            $table->decimal('precio', 8, 2)->default(0); // Precio al momento del servicio (por si cambia)
            $table->timestamps();
        });

        // Forzar engine InnoDB si el driver/servidor lo permite. No fatal on failure.
        try {
            DB::statement('ALTER TABLE servicio_reserva ENGINE=InnoDB');
        } catch (\Throwable $e) {
            // Ignore - non fatal in case user DB doesn't allow ALTER
        }
    }

    public function down()
    {
        if (! Schema::hasTable('servicio_reserva')) {
            return;
        }

        // No eliminar datos existentes: solo dropear si la tabla está vacía
        try {
            $count = DB::table('servicio_reserva')->count();
        } catch (\Throwable $e) {
            // Si falla el count, no intentar borrar para evitar pérdida de datos
            $count = null;
        }

        if ($count === 0) {
            Schema::dropIfExists('servicio_reserva');
        }
    }
};