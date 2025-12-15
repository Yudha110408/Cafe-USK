<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // cek email dulu
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]
        );
    }
}
