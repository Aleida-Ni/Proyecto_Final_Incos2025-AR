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
        Schema::create('trabajos_fallidos', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('conexion');
            $table->text('cola');
            $table->longText('carga_util');
            $table->longText('excepcion');
            $table->timestamp('fallado_en')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajos_fallidos');
    }
};
