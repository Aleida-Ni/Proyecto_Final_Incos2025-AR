<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('creado_en', 'created_at');
            $table->renameColumn('actualizado_en', 'updated_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('created_at', 'creado_en');
            $table->renameColumn('updated_at', 'actualizado_en');
        });
    }
};

