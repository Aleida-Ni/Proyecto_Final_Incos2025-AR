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
        Schema::create('tokens_acceso_personal', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('nombre');
            $table->string('token', 64)->unique();
            $table->text('habilidades')->nullable();
            $table->timestamp('ultimo_uso_en')->nullable();
            $table->timestamp('expira_en')->nullable();
            $table->timestamp('creado_en')->nullable();
            $table->timestamp('actualizado_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens_acceso_personal');
    }
};
