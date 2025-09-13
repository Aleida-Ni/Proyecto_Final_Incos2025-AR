<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'nombre' => 'Rck',
            'apellido_paterno' => 'Oz',
            'apellido_materno' => 'Melodian',
            'correo' => 'admin@gmail.com',
            'contraseña' => Hash::make('12345678'),
            'rol' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
