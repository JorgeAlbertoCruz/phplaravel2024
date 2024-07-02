<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('docente')->insert([
            'nombre' => 'jose',
            'apellido' => 'ramos',
            'email' => 'prof@admin.com',
            'password' => Hash::make('josee'),
        ]);

        DB::table('estudiante')->insert([
            'nombre' => 'Jorge',
            'apellido' => 'Cruz',
            'email' => 'jorge@estudiante.com',
            'pin' => Hash::make('prueba'),
        ]);
    }
}
