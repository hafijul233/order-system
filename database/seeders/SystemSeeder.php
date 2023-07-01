<?php 

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            StatusSeeder::class,
            RoleSeeder::class,
            SettingSeeder::class,
            CountrySeeder::class,
            UnitSeeder::class,
            //AttributeSeeder::class,
        ]);
        
        $this->call(StateSeeder::class, false, ["19"]);
        $this->call(CitySeeder::class, false, ["19"]);

    }
}