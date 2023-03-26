<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (array_chunk($this->data(), 300) as $block) {
            set_time_limit(2100);
            City::insert($block);
        }
    }

    private function data()
    {
        return include "cities.dat";
    }
}
