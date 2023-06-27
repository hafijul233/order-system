<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(...$arguments): void
    {
        $country_id = $arguments[0] ?? null;

        foreach (array_chunk($this->data($country_id), 300) as $block) {
            set_time_limit(2100);
            State::insert($block);
        }
    }

    private function data(int $country_id = null) : array
    {
        $data = include "states.dat";

        if($country_id != null) {
            return array_filter($data, fn($state) => ($state['country_id'] == $country_id));
        }

        return $data;
    }
}
