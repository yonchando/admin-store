<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ApiAccessToken;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StaffSeeder::class,
            CurrencySeeder::class,
            SettingSeeder::class,
            PermissionSeeder::class,
        ]);

        ApiAccessToken::create([
            'name' => 'APP',
            'token' => '71wRRfY6my5eXx8CD2k02APlQrY8H8VC2cEdLS2h',
        ]);
    }
}
