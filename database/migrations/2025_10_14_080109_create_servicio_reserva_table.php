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
        Schema::create('servicio_reserva', function (Blueprint $table) {
            $table->unsignedBigInteger('servicio_id');
            $table->unsignedBigInteger('reserva_id');
            $table->decimal('precio', 8, 2)->nullable();
            $table->timestamp('creado_en')->nullable();
            $table->timestamp('actualizado_en')->nullable();
            
            $table->primary(['servicio_id', 'reserva_id']);
            
            $table->foreign('servicio_id')
                  ->references('id')
                  ->on('servicios')
                  ->onDelete('cascade');
                  
            $table->foreign('reserva_id')
                  ->references('id')
                  ->on('reservas')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicio_reserva');
    }
};
