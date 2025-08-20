<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        
        Categoria::insert([
            ['nombre' => 'CERAS Y GELES'],
            ['nombre' => 'Peinado y estilizado'],
            ['nombre' => 'Cuidado de la barba y bigote'],
        ]);
    }
}
