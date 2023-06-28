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
        $this->call(SystemSeeder::class);

        $this->command->ask("Load Dummy Data", 'n');
    }
}
