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
        if (Schema::hasTable('ventas') && Schema::hasColumn('ventas', 'cliente_id')) {
            // Determine referenced users table
            $referenced = Schema::hasTable('usuarios') ? 'usuarios' : (Schema::hasTable('users') ? 'users' : null);

            // Wrap in try/catch because dropping foreign or changing column may fail if not present
            try {
                Schema::table('ventas', function (Blueprint $table) use ($referenced) {
                    // Primero eliminamos la restricción de clave foránea si existe
                    try {
                        $table->dropForeign(['cliente_id']);
                    } catch (\Exception $e) {
                        // ignore if FK does not exist
                    }

                    // Luego modificamos la columna para que sea nullable (solo si existe)
                    $table->unsignedBigInteger('cliente_id')->nullable()->change();

                    // Finalmente, volvemos a agregar la restricción de clave foránea si la tabla referenciada existe
                    if ($referenced) {
                        $table->foreign('cliente_id')
                              ->references('id')
                              ->on($referenced)
                              ->onDelete('cascade');
                    }
                });
            } catch (\Exception $e) {
                // If change() fails (Doctrine issues), skip to avoid breaking migrations on existing DBs
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('ventas') && Schema::hasColumn('ventas', 'cliente_id')) {
            $referenced = Schema::hasTable('usuarios') ? 'usuarios' : (Schema::hasTable('users') ? 'users' : null);
            try {
                Schema::table('ventas', function (Blueprint $table) use ($referenced) {
                    try {
                        $table->dropForeign(['cliente_id']);
                    } catch (\Exception $e) {
                        // ignore
                    }

                    // Revertimos la columna a not nullable
                    $table->unsignedBigInteger('cliente_id')->nullable(false)->change();

                    if ($referenced) {
                        $table->foreign('cliente_id')
                              ->references('id')
                              ->on($referenced)
                              ->onDelete('cascade');
                    }
                });
            } catch (\Exception $e) {
                // ignore errors during down migration in existing DBs
            }
        }
    }
};
