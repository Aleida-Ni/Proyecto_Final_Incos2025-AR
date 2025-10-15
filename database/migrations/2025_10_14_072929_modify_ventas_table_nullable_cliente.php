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
        Schema::table('ventas', function (Blueprint $table) {
            // Primero eliminamos la restricción de clave foránea
            $table->dropForeign(['cliente_id']);
            
            // Luego modificamos la columna para que sea nullable
            $table->unsignedBigInteger('cliente_id')->nullable()->change();
            
            // Finalmente, volvemos a agregar la restricción de clave foránea
            $table->foreign('cliente_id')
                  ->references('id')
                  ->on('usuarios')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            // Primero eliminamos la restricción de clave foránea
            $table->dropForeign(['cliente_id']);
            
            // Luego revertimos la columna a not nullable
            $table->unsignedBigInteger('cliente_id')->nullable(false)->change();
            
            // Finalmente, volvemos a agregar la restricción de clave foránea
            $table->foreign('cliente_id')
                  ->references('id')
                  ->on('usuarios')
                  ->onDelete('cascade');
        });
    }
};
