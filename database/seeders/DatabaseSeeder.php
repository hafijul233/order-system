<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StatusSeeder::class,
            RoleSeeder::class,
            SettingSeeder::class,
            CountrySeeder::class,
            CategorySeeder::class,
        ]);

        \App\Models\User::factory(15)->createQuietly();
        \App\Models\User::factory()->createQuietly([
            'name' => 'Hafijul Islam',
            'email' => 'hafijul233@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $this->call(CustomerSeeder::class);
        $this->call(CompanySeeder::class);
        \App\Models\Newsletter::factory(15)->createQuietly();
        \App\Models\Tag::factory(15)->createQuietly();


        $this->call(StateSeeder::class, false, ["19"]);
        $this->call(CitySeeder::class, false, ['19']);


    }
}
