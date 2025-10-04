<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            // 🔹 SOLO modificar el tipo de la columna estado si existe
            if (Schema::hasColumn('ventas', 'estado')) {
                // Cambiar el enum del estado para incluir los nuevos valores
                \DB::statement("ALTER TABLE ventas MODIFY estado ENUM('completada', 'anulada', 'pagado', 'pendiente') DEFAULT 'completada'");
            }
            
            // 🔹 Asegurar que empleado_id tenga la relación foreign key
            if (Schema::hasColumn('ventas', 'empleado_id')) {
                // Verificar si ya existe la foreign key
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $indexes = $sm->listTableIndexes('ventas');
                
                if (!isset($indexes['ventas_empleado_id_foreign'])) {
                    $table->foreign('empleado_id')->references('id')->on('usuarios');
                }
            }

            // 🔹 Asegurar que metodo_pago no sea nulo
            if (Schema::hasColumn('ventas', 'metodo_pago')) {
                \DB::statement("ALTER TABLE ventas MODIFY metodo_pago VARCHAR(255) NOT NULL");
            }

            // 🔹 Asegurar que fecha_pago no sea nulo
            if (Schema::hasColumn('ventas', 'fecha_pago')) {
                \DB::statement("ALTER TABLE ventas MODIFY fecha_pago DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
            }
        });
    }

    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            // Revertir el enum del estado
            if (Schema::hasColumn('ventas', 'estado')) {
                \DB::statement("ALTER TABLE ventas MODIFY estado ENUM('completada', 'anulada') DEFAULT 'completada'");
            }
            
            // Remover la foreign key si fue agregada
            if (Schema::hasColumn('ventas', 'empleado_id')) {
                $table->dropForeign(['empleado_id']);
            }
        });
    }
};