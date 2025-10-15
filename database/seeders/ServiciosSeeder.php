<?php



namespace Database\Seeders;



use Illuminate\Database\Console\Seeds\WithoutModelEvents;use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;use Illuminate\Database\Seeder;

use App\Models\Servicio;


class ServiciosSeeder extends Seeder{

  


    public function run(): void    {

    {        $servicios = [

        $servicios = [            [

            [                'nombre' => 'Corte de Cabello',

                'nombre' => 'Corte de Cabello',                'descripcion' => 'Corte de cabello tradicional o moderno según preferencia del cliente',

                'descripcion' => 'Corte de cabello tradicional o moderno según preferencia del cliente',                'precio' => 35.00,

                'precio' => 35.00,                'duracion_minutos' => 30,

                'duracion_minutos' => 30,                'activo' => true,

                'activo' => true                'creado_en' => now(),

            ],                'actualizado_en' => now()

            [            ],

                'nombre' => 'Afeitado Tradicional',            [

                'descripcion' => 'Afeitado completo con navaja y toalla caliente',                'nombre' => 'Afeitado Tradicional',

                'precio' => 25.00,                'descripcion' => 'Afeitado completo con navaja y toalla caliente',

                'duracion_minutos' => 25,                'precio' => 25.00,

                'activo' => true                'duracion_minutos' => 25,

            ],                'activo' => true,

            [                'creado_en' => now(),

                'nombre' => 'Corte y Barba',                'actualizado_en' => now()

                'descripcion' => 'Combinación de corte de cabello y arreglo de barba',            ],

                'precio' => 50.00,            [

                'duracion_minutos' => 45,                'nombre' => 'Corte y Barba',

                'activo' => true,
                'descripcion' => 'Combinación de corte de cabello y arreglo de barba',

            ],                'precio' => 50.00,

            [                'duracion_minutos' => 45,

                'nombre' => 'Diseño de Barba',                'activo' => true,

                'descripcion' => 'Perfilado y diseño personalizado de barba',                'creado_en' => now(),

                'precio' => 30.00,                'actualizado_en' => now()

                'duracion_minutos' => 20,            ],

                'activo' => true            [

            ],                'nombre' => 'Diseño de Barba',

            [                'descripcion' => 'Perfilado y diseño personalizado de barba',

                'nombre' => 'Corte de Niño',                'precio' => 30.00,

                'descripcion' => 'Corte especial para niños menores de 12 años',                'duracion_minutos' => 20,

                'precio' => 25.00,                'activo' => true,

                'duracion_minutos' => 25,                'creado_en' => now(),

                'activo' => true                'actualizado_en' => now()

            ],            ],

            [            [

                'nombre' => 'Fade Personalizado',                'nombre' => 'Corte de Niño',

                'descripcion' => 'Degradado personalizado según preferencia del cliente',                'descripcion' => 'Corte especial para niños menores de 12 años',

                'precio' => 40.00,                'precio' => 25.00,

                'duracion_minutos' => 35,                'duracion_minutos' => 25,

                'activo' => true                'activo' => true,

            ],                'creado_en' => now(),

            [                'actualizado_en' => now()

                'nombre' => 'Lavado y Peinado',            ],

                'descripcion' => 'Lavado de cabello con shampoo especial y peinado',            [

                'precio' => 20.00,                'nombre' => 'Fade Personalizado',

                'duracion_minutos' => 15,                'descripcion' => 'Degradado personalizado según preferencia del cliente',

                'activo' => true                'precio' => 40.00,

            ],                'duracion_minutos' => 35,

            [                'activo' => true,

                'nombre' => 'Tinte de Cabello',                'creado_en' => now(),

                'descripcion' => 'Aplicación de tinte con color a elección',                'actualizado_en' => now()

                'precio' => 80.00,            ],

                'duracion_minutos' => 60,            [

                'activo' => true                'nombre' => 'Lavado y Peinado',

            ]                'descripcion' => 'Lavado de cabello con shampoo especial y peinado',

        ];                'precio' => 20.00,

                'duracion_minutos' => 15,

        foreach ($servicios as $servicio) {                'activo' => true,

            Servicio::create($servicio);                'creado_en' => now(),

        }                'actualizado_en' => now()

    }            ],

}            [
                'nombre' => 'Tinte de Cabello',
                'descripcion' => 'Aplicación de tinte con color a elección',
                'precio' => 80.00,
                'duracion_minutos' => 60,
                'activo' => true,
                'creado_en' => now(),
                'actualizado_en' => now()
            ]
        ];

        foreach ($servicios as $servicio) {
            \App\Models\Servicio::create($servicio);
        }
    }
}
