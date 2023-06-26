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
            UserSeeder::class,
            CustomerSeeder::class,
            CompanySeeder::class,
            AddressBookSeeder::class,
            NewsLetterSeeder::class, 
            PaymentOptionSeeder::class,

        ]);

        \App\Models\Tag::factory(15)->createQuietly();

        $this->call(StateSeeder::class, false, ["19"]);
        $this->call(CitySeeder::class, false, ["19"]);
    }
}
