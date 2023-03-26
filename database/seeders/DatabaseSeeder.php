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

        \App\Models\User::factory(15)->createQuietly();
        \App\Models\User::factory()->createQuietly([
            'name' => 'Hafijul Islam',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        \App\Models\Customer::factory(15)->createQuietly();
        \App\Models\Category::factory(15)->createQuietly();
        \App\Models\Company::factory(15)->createQuietly();
        \App\Models\Newsletter::factory(15)->createQuietly();
        \App\Models\Tag::factory(15)->createQuietly();
        $this->call(SettingSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(CitySeeder::class);

    }
}
