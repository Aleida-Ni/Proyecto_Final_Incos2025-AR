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
        if (! Schema::hasTable('detalles_venta')) {
            Schema::create('detalles_venta', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('venta_id');
                $table->unsignedBigInteger('producto_id')->nullable();
                $table->unsignedBigInteger('servicio_id')->nullable();
                $table->integer('cantidad');
                $table->decimal('precio_unitario', 10, 2);
                $table->decimal('subtotal', 10, 2);
                $table->timestamps();
                
                $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');
                $table->foreign('producto_id')->references('id')->on('productos')->onDelete('set null');
                $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_venta');
    }
};
