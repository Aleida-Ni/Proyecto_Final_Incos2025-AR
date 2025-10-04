<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('servicio_reserva', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reserva_id')->constrained()->onDelete('cascade');
            $table->foreignId('servicio_id')->constrained()->onDelete('cascade');
            $table->decimal('precio', 8, 2); // Precio al momento del servicio (por si cambia)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('servicio_reserva');
    }
};