<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Servicio;

class ServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servicios = [
            [
                'nombre' => 'Corte de Cabello',
                'descripcion' => 'Corte de cabello tradicional o moderno según preferencia del cliente',
                'precio' => 35.00,
                'duracion_minutos' => 30,
                'activo' => true,
                'creado_en' => now(),
                'actualizado_en' => now(),
            ],
            [
                'nombre' => 'Afeitado Tradicional',
                'descripcion' => 'Afeitado completo con navaja y toalla caliente',
                'precio' => 25.00,
                'duracion_minutos' => 25,
                'activo' => true,
                'creado_en' => now(),
                'actualizado_en' => now(),
            ],
            [
                'nombre' => 'Corte y Barba',
                'descripcion' => 'Combinación de corte de cabello y arreglo de barba',
                'precio' => 50.00,
                'duracion_minutos' => 45,
                'activo' => true,
                'creado_en' => now(),
                'actualizado_en' => now(),
            ],
            [
                'nombre' => 'Diseño de Barba',
                'descripcion' => 'Perfilado y diseño personalizado de barba',
                'precio' => 30.00,
                'duracion_minutos' => 20,
                'activo' => true,
                'creado_en' => now(),
                'actualizado_en' => now(),
            ],
            [
                'nombre' => 'Corte de Niño',
                'descripcion' => 'Corte especial para niños menores de 12 años',
                'precio' => 25.00,
                'duracion_minutos' => 25,
                'activo' => true,
                'creado_en' => now(),
                'actualizado_en' => now(),
            ],
            [
                'nombre' => 'Fade Personalizado',
                'descripcion' => 'Degradado personalizado según preferencia del cliente',
                'precio' => 40.00,
                'duracion_minutos' => 35,
                'activo' => true,
                'creado_en' => now(),
                'actualizado_en' => now(),
            ],
            [
                'nombre' => 'Lavado y Peinado',
                'descripcion' => 'Lavado de cabello con shampoo especial y peinado',
                'precio' => 20.00,
                'duracion_minutos' => 15,
                'activo' => true,
                'creado_en' => now(),
                'actualizado_en' => now(),
            ],
            [
                'nombre' => 'Tinte de Cabello',
                'descripcion' => 'Aplicación de tinte con color a elección',
                'precio' => 80.00,
                'duracion_minutos' => 60,
                'activo' => true,
                'creado_en' => now(),
                'actualizado_en' => now(),
            ],
        ];

        foreach ($servicios as $servicio) {
            Servicio::create($servicio);
        }
    }
}
