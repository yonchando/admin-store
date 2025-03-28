<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        if (Staff::first() == null) {
            Staff::create([
                'name' => 'Super Admin',
                'position' => 'Super Admin',
                'username' => 'admin',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]);
        }

        //        Staff::factory(40)->create();
    }
}
