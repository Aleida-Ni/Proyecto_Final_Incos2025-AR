<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Primero verificamos si la columna no existe para evitar errores
        if (!Schema::hasColumn('productos', 'descripcion')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->text('descripcion')->nullable()->after('nombre');
            });
        }

        // Renombramos los timestamps solo si existen las columnas originales
        if (Schema::hasColumn('productos', 'created_at')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->renameColumn('created_at', 'creado_en');
            });
        }
        
        if (Schema::hasColumn('productos', 'updated_at')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->renameColumn('updated_at', 'actualizado_en');
            });
        }
    }

    public function down(): void
    {
        // Primero verificamos si la columna existe antes de intentar eliminarla
        if (Schema::hasColumn('productos', 'descripcion')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->dropColumn('descripcion');
            });
        }

        // Revertimos los nombres de los timestamps si existen
        if (Schema::hasColumn('productos', 'creado_en')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->renameColumn('creado_en', 'created_at');
            });
        }
        
        if (Schema::hasColumn('productos', 'actualizado_en')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->renameColumn('actualizado_en', 'updated_at');
            });
        }
    }
};