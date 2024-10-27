<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (User::first() == null) {
            User::create([
                'name' => 'Super Admin',
                'position' => 'Super Admin',
                'username' => 'admin',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]);
        }
    }
}
