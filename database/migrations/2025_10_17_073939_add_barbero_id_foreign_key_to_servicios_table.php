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
    Schema::table('servicios', function (Blueprint $table) {
        $table->foreign('barbero_id')
              ->references('id')
              ->on('barberos')
              ->onDelete('set null')
              ->onUpdate('cascade');
    });
}

public function down(): void
{
    Schema::table('servicios', function (Blueprint $table) {
        $table->dropForeign(['barbero_id']);
    });
}

};
