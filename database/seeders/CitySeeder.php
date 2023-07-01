<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(...$arguments): void
    {
        $country_id = $arguments[0] ?? null;

        foreach (array_chunk($this->data($country_id), 300) as $block) {
            set_time_limit(2100);
            City::insert($block);
        }
    }

    private function data(int $country_id = null)
    {
        $data = include "cities.dat";

        if ($country_id != null) {
            return array_filter($data, fn($state) => ($state['country_id'] == $country_id));
        }

        return $data;
    }
}
