<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            CustomerSeeder::class,
            CompanySeeder::class,
            AddressBookSeeder::class,
            NewsLetterSeeder::class, 
            PaymentOptionSeeder::class,
            ProductSeeder::class,
        ]);

        \App\Models\Tag::factory(15)->createQuietly();
    }
}
